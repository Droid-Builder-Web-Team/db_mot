<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Droid;

class ToppsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $droids = Droid::where('topps_id', '!=', 0)
            ->where('topps_run', 1)
            ->orderBy('topps_id')
            ->paginate(8);
        return view('topps', compact('droids'));
    }

    public function displayToppsImage($uid, $view, $size = '')
    {
        $droid = Droid::find($uid);

        if (!in_array($view, array('topps_front', 'topps_rear'))) {
            abort(403);
        }

        // Check if user is authorized to view this droid's images
        $user = auth()->user();
        $isAuthorized = $user && ($droid->users->contains($user) || $user->can('View Droids'));
        if (!$isAuthorized && $droid->public != "Yes") {
            abort(403);
        }

        if ($size != "") {
            $size = $size . '-';
        }
        $path = 'droids/' . $uid . '/' . $size . '' . $view . '.png';
        if (!Storage::exists($path)) {
            $path = 'droids/' . $uid . '/' . $size . '' . $view . '.jpg';
        }

        if (!Storage::exists($path)) {
            $localPath = public_path('img/blank_' . $view . '.jpg');
            if (file_exists($localPath)) {
                return response()->file($localPath);
            }
            // fallback for dev environments
            $oldPath = getcwd() . '/img/blank_' . $view . '.jpg';
            if (file_exists($oldPath)) {
                return response()->file($oldPath);
            }
            abort(404);
        }

        // If using S3, generate a signed URL to offload the transfer to AWS
        if (config('filesystems.default') === 's3' || config('filesystems.cloud') === 's3') {
            return redirect()->away(Storage::temporaryUrl($path, now()->addMinutes(5)));
        }

        // Fallback for local development
        $file = Storage::get($path);
        $type = Storage::mimeType($path);
        return Response::make($file, 200)->header("Content-Type", $type);
    }
}
