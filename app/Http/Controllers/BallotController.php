<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Ballot;
use App\Models\Vote;
use App\Models\VoterLog;
use App\Models\Candidate;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BallotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $ballots = Ballot::with('voterLogs')->get();
            return view('ballots.index', compact('ballots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        if (!auth()->user()->can('Edit Ballot')) {
            abort(403);
        }
        $users = User::all(); // Fetch all users to be presented as potential candidates.
        return view('admin.ballots.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('Edit Ballot')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'candidate_ids' => 'required|array|min:2', // Require at least two candidates.
            'candidate_ids.*' => 'exists:members,id', // Ensure each ID exists in the users table.
        ]);

        DB::transaction(function () use ($validatedData) {
            // Create the ballot
            $ballot = Ballot::create([
                'title' => $validatedData['title'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'is_active' => true, // You can make this optional if you want a separate activation step.
            ]);

            // Attach candidates from the selected users
            foreach ($validatedData['candidate_ids'] as $userId) {
                $user = User::find($userId);
                $ballot->candidates()->create([
                    'name' => $user->forename.' '.$user->surname,
                    'description' => 'Candidate from user ID: ' . $user->id,
                ]);
            }
        });

        return redirect()->route('admin.ballots.index')->with('success', 'Ballot created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Ballot $ballot)
    {
        // Check if the user has already voted in this ballot.
        $hasVoted = VoterLog::where('user_id', \Auth::id())
                            ->where('ballot_id', $ballot->id)
                            ->exists();

        // Check if the ballot is currently open for voting.
        $now = now();
        $isVotingOpen = $now->between($ballot->start_date, $ballot->end_date);

        // Fetch the candidates associated with the ballot.
        $candidates = $ballot->candidates()->get();

        return view('ballots.show', compact('ballot', 'candidates', 'hasVoted', 'isVotingOpen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ballot $ballot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ballot $ballot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ballot $ballot)
    {

        if (!auth()->user()->can('Edit Ballot')) {
            abort(403);
        }

        DB::transaction(function () use ($ballot) {
            // Delete all associated candidates.
            // This will trigger a cascading delete of votes due to the 'onDelete' cascade
            // specified in your candidates migration.
            $ballot->candidates()->delete();

            // Delete the ballot itself.
            $ballot->delete();
        });

        return redirect()->route('admin.ballots.index')->with('success', 'Ballot deleted successfully!');
    }

    /**
     * Handle the voting submission.
     */
    public function vote(Request $request, Ballot $ballot)
    {
        // 1. Validate the user's choices.
        $request->validate([
            'first_choice' => [
                'required',
                'integer',
                Rule::exists('candidates', 'id')->where(function ($query) use ($ballot) {
                    return $query->where('ballot_id', $ballot->id);
                }),
            ],
            'second_choice' => [
                'nullable',
                'integer',
                Rule::exists('candidates', 'id')->where(function ($query) use ($ballot) {
                    return $query->where('ballot_id', $ballot->id);
                }),
                'different:first_choice',
            ],
            'third_choice' => [
                'nullable',
                'integer',
                Rule::exists('candidates', 'id')->where(function ($query) use ($ballot) {
                    return $query->where('ballot_id', $ballot->id);
                }),
                'different:first_choice',
                'different:second_choice',
            ],
        ]);
    
        // 2. Enforce the one-ballot-per-user rule.
        if (VoterLog::where('user_id', \Auth::id())->where('ballot_id', $ballot->id)->exists()) {
            return redirect()->back()->with('error', 'You have already cast your vote in this ballot.');
        }
    
        // 3. Record the votes and the voter log in a database transaction.
        DB::transaction(function () use ($request, $ballot) {
            // Record the first choice (3 points)
            Vote::create([
                'ballot_id' => $ballot->id,
                'candidate_id' => $request->first_choice,
                'rank' => 1,
            ]);
    
            // Record the second choice (2 points), if provided.
            if ($request->second_choice) {
                Vote::create([
                    'ballot_id' => $ballot->id,
                    'candidate_id' => $request->second_choice,
                    'rank' => 2,
                ]);
            }
    
            // Record the third choice (1 point), if provided.
            if ($request->third_choice) {
                Vote::create([
                    'ballot_id' => $ballot->id,
                    'candidate_id' => $request->third_choice,
                    'rank' => 3,
                ]);
            }
    
            // Record that the user has voted.
            VoterLog::create([
                'ballot_id' => $ballot->id,
                'user_id' => \Auth::id(),
            ]);
        });
    
        return redirect()->route('ballots.show', $ballot)->with('success', 'Your vote has been cast. Thank you for your participation!');
    }

    public function results(Ballot $ballot)
    {
        // Make sure the ballot is completed before showing results
        if (now()->lessThan($ballot->end_date)) {
            return redirect()->back()->with('error', 'Results are not yet available for this ballot.');
        }
    
        // Tally the votes
        $results = DB::table('votes')
            ->select('candidate_id', DB::raw('SUM(
                CASE
                    WHEN rank = 1 THEN 3
                    WHEN rank = 2 THEN 2
                    WHEN rank = 3 THEN 1
                    ELSE 0
                END) AS total_score'))
            ->where('ballot_id', $ballot->id)
            ->groupBy('candidate_id')
            ->orderByDesc('total_score')
            ->get();
    
        // Get candidate names
        $candidates = Candidate::whereIn('id', $results->pluck('candidate_id'))->get()->keyBy('id');
    
        return view('ballots.results', compact('ballot', 'results', 'candidates'));
    }
}
