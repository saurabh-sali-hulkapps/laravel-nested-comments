<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    /**
     * Show the form for creating a new comment.
     *
     * @param Post $post
     * @return Application|Factory|View|Response
     */
    public function create(Post $post)
    {
        $comment = [
            'id' => $post->id,
            'message' => '',
        ];

        return view('livewire.comment-create', ['comment' => $comment]);
    }

    /**
     * Store a newly created comment in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function store(Request $request, Post $post): RedirectResponse
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user()->associate(Auth::user()->id);
        $post = Post::find($post->id);
        $post->comments()->save($comment);

        $details = [
            'user' => Auth::user()->name,
            'body' => 'has commented on your Post:- ',
            'post' => $post->title
        ];

        Mail::to($post->user->email)->send(new SendMail($details));

        return back();
    }

    /**
     * Send the json data for editing the specified comment.
     *
     * @param Comment $comment
     */
    public function edit(Comment $comment)
    {
        echo json_encode($comment);
    }

    /**
     * Update the specified comment in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        Comment::where('id', $comment->id)
            ->update([
                'comment' => $request->comment,
            ]);

        return back();
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        Comment::destroy($comment->id);
        return back();
    }

    /**
     * Store a newly created reply in storage.
     *
     * @param Request $request
     * @param Post $post
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function repliesStore(Request $request, Post $post, Comment $comment): RedirectResponse
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $reply = new Comment();
        $reply->comment = $request->reply;
        $reply->user()->associate(Auth::user()->id);
        $reply->parent_id = $comment->id;
        $post = Post::find($post->id);
        $post->comments()->save($reply);

        $details = [
            'user' => Auth::user()->name,
            'body' => 'has replied on your Comment',
            'post' => ''
        ];

        Mail::to($comment->user->email)->send(new SendMail($details));

        return back();
    }
}
