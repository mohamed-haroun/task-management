<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use HttpResponses;

    /**
     * Store a newly created resource in storage.
     */
    public function store(Task $task, Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:255',
            'comment_id' => 'sometimes|nullable|integer|exists:comments,id',
        ]);

        $task->comments()->create([
            'body' => $request->post('body'),
            'user_id' => Auth::id(),
            'comment_id' => $request->post('comment_id') ?? null,
        ]);

        return $this->success([
            'message' => 'Comment created successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Task $task, Comment $comment, Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:255',
        ]);

        $task->comments()->update($request->only('body'));

        return $this->success([
            'message' => 'Comment updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, $comment){
        $task->comments()->where('id', $comment)->delete();
        return $this->success([
            'message' => 'Comment deleted successfully'
        ]);
    }
}
