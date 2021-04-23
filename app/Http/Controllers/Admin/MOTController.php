<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MOT;
use App\Droid;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\MOTAdded;

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
        if (!$droid->club->hasOption('mot'))
            return view('droid.show', compact('droid'));

        $sections = DB::table('mot_sections')
                      ->where('club_id', $droid->club_id)
                      ->get();
        return view('admin.mot.create', compact('droid', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'location' => 'required'
        ]);

        // Save main data
        $mot = new MOT;
        $mot->droid_id = $request->droid_id;
        $mot->user = $request->user;
        $mot->date = $request->date;
        $mot->location = $request->location;
        $mot->approved = $request->approved;
        $mot->mot_type = $request->mot_type;
        $mot->save();

        if ($request->new_comment != "") {
            $comment = DB::table('mot_comments')
                          ->insert([
                              'mot_uid' => $mot->id,
                              'comment' => $request->new_comment,
                              'added_by' => $request->user
                          ]);
        }

        $lines = DB::table('mot_lines')
                    ->where('club_id', $request->club_id)
                    ->get();

        foreach($lines as $line) {
            $detail = DB::table('mot_details')
                        ->insert([
                              'mot_uid' => $mot->id,
                              'mot_test' => $line->test_name,
                              'mot_test_result' => $request->{$line->test_name}
                          ]);
        }

        // Notify owners
        $droid = Droid::find($request->droid_id);
        foreach($droid->users as $user)
        {
              $user->notify(new MOTAdded($mot));
        }
        toastr()->success('MOT added successfully');

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
