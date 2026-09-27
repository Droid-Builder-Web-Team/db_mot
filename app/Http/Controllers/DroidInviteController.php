<?php

namespace App\Http\Controllers;

use App\Droid;
use App\DroidInvite;
use App\Notifications\DroidInviteNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class DroidInviteController extends Controller
{
    /**
     * Search users for sharing by query string (min 3 chars).
     *
     * @param Request $request
     * @param Droid $droid
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchUsers(Request $request, Droid $droid)
    {
        $term = trim($request->get('q', ''));

        if (mb_strlen($term) < 3) {
            return response()->json(['results' => []]);
        }

        $existingOwnerIds = $droid->users()->pluck('members.id')->toArray();
        if (!$this->isDroidAdmin()) {
            $existingOwnerIds[] = auth()->id();
        }

        $words = array_values(array_filter(explode(' ', $term)));

        $users = User::where('active', 'on')
            ->whereNotIn('id', $existingOwnerIds)
            ->where(function ($query) use ($term, $words) {
                $query->where('email', 'like', "%{$term}%");
                if (count($words) > 1) {
                    $query->orWhere(function ($q) use ($words) {
                        foreach ($words as $word) {
                            $q->where(function ($w) use ($word) {
                                $w->where('forename', 'like', "%{$word}%")
                                    ->orWhere('surname', 'like', "%{$word}%");
                            });
                        }
                    });
                } else {
                    $query->orWhere('forename', 'like', "%{$term}%")
                        ->orWhere('surname', 'like', "%{$term}%");
                }
            })
            ->orderBy('forename')
            ->orderBy('surname')
            ->limit(25)
            ->get();

        $results = $users->map(function ($u) {
            return [
                'id' => $u->id,
                'forename' => $u->forename,
                'surname' => $u->surname,
                'email' => $u->email,
                'text' => "{$u->forename} {$u->surname} ({$u->email})",
            ];
        });

        return response()->json(['results' => $results]);
    }

    /**
     * Send an invite to share the droid.
     *
     * @param Request $request
     * @param Droid $droid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Droid $droid)
    {
        if (!$droid->users->contains(auth()->user()) && !auth()->user()->can('Edit Droids')) {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:members,id',
        ]);

        $targetUser = User::findOrFail($request->user_id);

        if ($targetUser->id === auth()->id() && $droid->users->contains(auth()->user())) {
            flash()->addError('You already own this droid.');
            return redirect()->route('droid.show', $droid->id);
        }

        // Check if recipient is already an owner
        if ($droid->users->contains($targetUser)) {
            flash()->addError('This member is already an owner of this droid.');
            return redirect()->route('droid.show', $droid->id);
        }

        // Admin bypass: directly add co-owner without sending an email invite
        if ($this->isDroidAdmin()) {
            $droid->users()->syncWithoutDetaching([$targetUser->id]);

            // Clean up any pending invites for this member on this droid
            DroidInvite::where('droid_id', $droid->id)
                ->where('invited_user_id', $targetUser->id)
                ->delete();

            flash()->addSuccess("{$targetUser->forename} {$targetUser->surname} added directly as an owner.");
            return redirect()->route('droid.show', $droid->id);
        }

        // Create or update pending invite
        $invite = DroidInvite::updateOrCreate(
            [
                'droid_id' => $droid->id,
                'invited_user_id' => $targetUser->id,
            ],
            [
                'invited_by' => auth()->id(),
                'email' => $targetUser->email,
                'token' => Str::random(48),
                'expires_at' => now()->addDays(7),
            ]
        );

        // Send notification
        $targetUser->notify(new DroidInviteNotification($invite));

        flash()->addSuccess("Invitation sent to {$targetUser->forename} {$targetUser->surname} ({$targetUser->email}).");
        return redirect()->route('droid.show', $droid->id);
    }

    /**
     * Cancel/revoke a pending invitation.
     *
     * @param DroidInvite $invite
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DroidInvite $invite)
    {
        $droid = $invite->droid;
        if (!$droid || (!$droid->users->contains(auth()->user()) && !auth()->user()->can('Edit Droids'))) {
            abort(403);
        }

        $invite->delete();

        flash()->addSuccess('Invitation cancelled.');
        return redirect()->route('droid.show', $droid->id);
    }

    /**
     * Display the invitation acceptance screen.
     *
     * @param string $token
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showAccept($token)
    {
        $invite = DroidInvite::where('token', $token)->first();

        if (!$invite) {
            flash()->addError('This invitation link is invalid or has already been used.');
            return redirect()->route('home');
        }

        if ($invite->isExpired()) {
            $invite->delete();
            flash()->addError('This invitation has expired.');
            return redirect()->route('home');
        }

        $droid = $invite->droid;
        if (!$droid) {
            $invite->delete();
            flash()->addError('The droid associated with this invitation no longer exists.');
            return redirect()->route('home');
        }

        if (!auth()->check()) {
            session(['url.intended' => route('droid.invite.accept', $token)]);
        }

        return view('droid.invite.accept', compact('invite', 'droid'));
    }

    /**
     * Process acceptance of the invitation.
     *
     * @param Request $request
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmAccept(Request $request, $token)
    {
        if (!auth()->check()) {
            session(['url.intended' => route('droid.invite.accept', $token)]);
            return redirect()->route('login');
        }

        $invite = DroidInvite::where('token', $token)->first();

        if (!$invite) {
            flash()->addError('This invitation link is invalid or has already been used.');
            return redirect()->route('home');
        }

        if ($invite->isExpired()) {
            $invite->delete();
            flash()->addError('This invitation has expired.');
            return redirect()->route('home');
        }

        $droid = $invite->droid;
        if (!$droid) {
            $invite->delete();
            flash()->addError('The droid associated with this invitation no longer exists.');
            return redirect()->route('home');
        }

        $user = auth()->user();

        if ($droid->users->contains($user)) {
            $invite->delete();
            flash()->addInfo("You already share ownership of {$droid->name}.");
            return redirect()->route('droid.show', $droid->id);
        }

        $droid->users()->syncWithoutDetaching([$user->id]);
        $invite->delete();

        flash()->addSuccess("You now share ownership of {$droid->name}!");
        return redirect()->route('droid.show', $droid->id);
    }

    /**
     * Decline an invitation.
     *
     * @param Request $request
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline(Request $request, $token)
    {
        $invite = DroidInvite::where('token', $token)->first();

        if ($invite) {
            $invite->delete();
            flash()->addInfo('Invitation declined.');
        }

        return redirect()->route('home');
    }

    /**
     * Remove a user from a shared droid.
     *
     * @param Request $request
     * @param Droid $droid
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeUser(Request $request, Droid $droid, User $user)
    {
        $currentUser = auth()->user();

        $isOwner = $droid->users->contains($currentUser);
        $isSelf = $currentUser->id === $user->id;

        if (!$isOwner && !$isSelf && !$currentUser->can('Edit Droids')) {
            abort(403);
        }

        if ($droid->users()->count() <= 1) {
            flash()->addError('Cannot remove the only owner of a droid.');
            return redirect()->route('droid.show', $droid->id);
        }

        $droid->users()->detach($user->id);

        if ($isSelf) {
            flash()->addSuccess("You have unlinked yourself from {$droid->name}.");
            return redirect()->route('user.show', $currentUser->id);
        }

        flash()->addSuccess("{$user->forename} {$user->surname} has been removed from {$droid->name}.");
        return redirect()->route('droid.show', $droid->id);
    }

    /**
     * Check if the authenticated user has droid administration permissions.
     *
     * @return bool
     */
    protected function isDroidAdmin(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        try {
            if (auth()->user()->can('Edit Droids')) {
                return true;
            }

            return auth()->user()->hasRole(['Super Admin', 'Org Admin']);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
