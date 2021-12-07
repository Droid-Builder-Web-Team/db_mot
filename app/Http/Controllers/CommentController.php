<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
      $model = app($request->model)::find($request->id);

      $request->validate([
          'body' => 'required',
      ]);
      $comment = new Comment;
      $comment->body = $request->body;
      $comment->user_id = auth()->user()->id;

      switch ($request->model) {
        case "App\Event":
          $permission = "Edit Events";
        case "App\PartRunData":
          $permission = "Edit Partrun";
        default:
          $permission = "";
      }

      if ($permission != "")
      {
        if (auth()->user()->can($permission) && $request->broadcast == 'on')
        {
          foreach($event->users as $user)
          {
            switch ($request->model) {
              case "App\Event":
                $user->notify(new EventUpdated($model));
              case "App\PartRunData":
                $user->notify(new PartsRunUpdated($model));
              default:
                echo "error";
            }
          }
          $comment->broadcast = true;
        }
      }

      $result = $model->comments()->save($comment);
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
        return response()->json([
            'message' => 'Liked',
        ]);
    }

}
