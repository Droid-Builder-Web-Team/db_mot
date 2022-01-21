<?php

/**
 * Create MOT
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Droid;
use App\Http\Controllers\Controller;
use App\Http\Requests\MOTStoreRequest;
use App\MOT;
use App\Notifications\MOTAdded;
use App\Notifications\FirstMOT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * MOT Controller
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class MOTController extends Controller
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:Add MOT');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param integer $droid_id Id of droid having MOT
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
     * @param \App\Requests\MOTStoreRequest $request Store request
     *
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

                foreach ($lines as $line) {
                    DB::table('mot_details')->insert(
                        [
                        'mot_uid' => $mot->id,
                        'mot_test' => $line->test_name,
                        'mot_test_result' => $request->{$line->test_name},
                        ]
                    );
                }

                return $mot;

            }
        );

        // Notify owners


        $droid = Droid::find($request->droid_id);
        foreach ($droid->users as $user) {
            if ($user->firstMot()) {
                $user->notify(new FirstMOT($mot));
                $id = DB::table('id_list')->insert(
                    [
                        'user_id' => $user->id,
                        'reissue' => false,
                        'paid' => false
                    ]
                );
            } else {
                $user->notify(new MOTAdded($mot));
            }
        }

        toastr()->success('MOT added successfully');

        return redirect()->route('droid.show', $request->droid_id);
    }

    /**
     * Add comment to MOT
     *
     * @param \Illuminate\Http\Request $request HTTP Request
     * @param \App\MOT                 $mot     MOT model
     *
     * @return void
     */
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
