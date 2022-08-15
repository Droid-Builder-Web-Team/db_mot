<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Droid;
use App\Club;
use App\CourseRun;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{

    public function list_bcreps($club_id)
    {
        $reps = [];
        $club = Club::find($club_id);

        $allreps = User::role('BC Rep')->get(['id', 'surname', 'forename']);
        foreach($allreps as $rep)
        {
            if($rep->isAdminOf($club)) {
                array_push($reps, $rep);
            }
        }

        return response()->json($reps);
    }

    public function drivingCourseDownload()
    {
        $data = User::with('droids')
                    ->where("active", "on")->get();
        $data->makeHidden(['api_token', 'calendar_id', 'droid.notes']);
        return response()->json(strip_tags($data));
    }

    public function get_member_image($uid, $size = 240)
    {
        if ($size != "") {
            $size = $size.'-';
        }
        //return redirect(Storage::temporaryUrl('members/'.$uid.'/'.$size.'mug_shot.jpg', now()->addMinutes(5)));
        $path = 'members/'.$uid.'/'.$size.'mug_shot.png';
        if (!Storage::exists($path)) {
            $path = 'members/'.$uid.'/'.$size.'mug_shot.jpg';
        }
        //return redirect(Storage::temporaryUrl($path, now()->addMinutes(5)));
        if (!Storage::exists($path)) {
            $path = getcwd().'/img/blank_mug_shot.jpg';
            $file = file_get_contents($path);
            $type = "image/jpeg";
        } else {
            $file = Storage::get($path);
            $type = Storage::mimeType($path);
        }
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function get_droid_image($uid, $view = 'photo_front', $size=240)
    {
        $droid = Droid::find($uid);

        if ($size != "") {
            $size = $size.'-';
        }
        $path = 'droids/'.$uid.'/'.$size.''.$view.'.png';
        if (!Storage::exists($path)) {
            $path = 'droids/'.$uid.'/'.$size.''.$view.'.jpg';
        }
        if (!Storage::exists($path)) {
            $path = getcwd().'/img/blank_'.$view.'.jpg';
            $file = file_get_contents($path);
            $type = "image/jpeg";
        } else {
            $file = Storage::get($path);
            $type = Storage::mimeType($path);
        }
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }    

    public function upload_course_run(Request $request)
    {
        $run = json_decode($request->json);

        print(json_encode($run));

        $courserun = new CourseRun();
        $courserun->run_type = 1;
        $courserun->user_id = $run->member_uid;
        $courserun->droid_id = $run->droid_uid;
        $courserun->first_half = $run->first_half;
        $courserun->second_half = $run->second_half;
        $courserun->clock_time = $run->clock_time;
        $courserun->final_time = $run->final_time;
        $courserun->num_penalties = $run->num_penalties;
        $courserun->penalties = json_encode($run->penalties);
        $courserun->dribble = 0;
        $courserun->timestamps = false;
        $courserun->run_timestamp = $run->start;
        $courserun->save();
    }
}
