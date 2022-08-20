<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Comment;
use App\Notifications\CommentBroadcast;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $model = app($request->model)::find($request->id);

        $request->validate(
            [
            'body' => 'required',
            ]
        );
        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user_id = auth()->user()->id;

        $result = $model->comments()->save($comment);

        if ($request->broadcast == 'on') {
            switch ($request->model) {
            case "App\Event":
                $permission = "Edit Events";
                break;
            case "App\PartsRunData":
                $permission = "Edit Partrun";
                break;
            case "App\Models\Auction":
                $permission = "Edit Auction";
                break;
            case "App\CourseRun":
                $permission = "Edit Members";
                break;
            case "App\Location":
                $permission = "Edit Events";
                break;
            default:
                $permission = "";
                break;
            }

            if ($permission != "") {
                if (auth()->user()->can($permission)) {
                    foreach($model->users as $user)
                    {
                        switch ($request->model) {
                        case "App\Event":
                            $user->notify(new CommentBroadcast($result));
                            break;
                        case "App\PartsRunData":
                            $user->notify(new CommentBroadcast($result));
                            break;
                        case "App\Models\Auction":
                            $user->notify(new CommentBroadcast($result));
                            break;
                        case "App\CourseRun":
                            $user->notify(new CommentBroadcast($result));
                            break;
                        case "App\Location":
                            $user->notify(new CommentBroadcast($result));
                            break;
                        default:
                              echo "error";
                            break;
                        }
                    }
                    $result->broadcast = true;
                    $result->save();
                }
            }

        }


        toastr()->success('Comment Added');
        return back();
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        toastr()->success('Comment Deleted');
        return back();
    }


    public function fetchReactions(Request $request)
    {
        $comment = Comment::find($request->comment);
        return response()->json(
            $comment->reaction_summary->toArray(),
        );
    }

    public function handleReaction(Request $request)
    {
        $comment = Comment::find($request->id);
        $comment->toggleReaction($request->reaction);
        return response()->json(
            [
            'message' => 'Liked',
            ]
        );
    }

}
