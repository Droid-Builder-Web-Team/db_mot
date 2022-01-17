<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Droid;
use App\Http\Controllers\Controller;
use App\Http\Requests\MOTStoreRequest;
use App\MOT;
use App\Notifications\MOTAdded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MOTController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:Add MOT');

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($droid_id)
    {
        $droid = Droid::find($droid_id);

        // If club doesn't use MOTs, return to droid
        if (!$droid->club->hasOption('mot')) {
            return view('droid.show', compact('droid'));
        }

        $sections = DB::table('mot_sections')
            ->where('club_id', $droid->club_id)
            ->get();
        return view('admin.mot.create', compact('droid', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MOTStoreRequest $request)
    {
        $mot = DB::transaction(
            function () use ($request) {
                // Save main data
                $mot = MOT::create($request->all());

                if ($request->body != "") {
                    $comment = new Comment();
                    $comment->body = $request->body;
                    $comment->user_id = auth()->user()->id;

                    $mot->comments()->save($comment);
                    toastr()->success('Comment Added');
                }

                $lines = DB::table('mot_lines')
                    ->where('club_id', $request->club_id)
                    ->get();

                foreach ($lines as $line)
                {
                    DB::table('mot_details')->insert(
                        [
                        'mot_uid' => $mot->id,
                        'mot_test' => $line->test_name,
                        'mot_test_result' => $request->{$line->test_name},
                        ]
                    );
                }

                return $mot;

            
                /*
                if ($mot->approved == "Yes") {
                $url = "https://graph.facebook.com/v8.0/".config('fb.fbgroup')."/feed";
                $message = "Congratulations to our latest member to have their droid pass its first MOT\r\n";

                $data['message'] = $message;
                $data['access_token'] = config('fb.fb_access_token');
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $return = curl_exec($ch);
                curl_close($ch);
                dd($return);

                }
                */
            }
        );

        // Notify owners
        $droid = Droid::find($request->droid_id);
        foreach ($droid->users as $user)
        {
            $user->notify(new MOTAdded($mot));
        }

        toastr()->success('MOT added successfully');

        return redirect()->route('droid.show', $request->droid_id);
    }

    public function comment(Request $request, MOT $mot)
    {

        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user_id = auth()->user()->id;

        $result = $mot->comments()->save($comment);
        toastr()->success('Comment Added');
        return view('mot.show', compact('mot'));
    }
}
