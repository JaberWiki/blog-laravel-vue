<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Response;

class CommentController extends Controller {
    public function index(Post $post) {
        return CommentResource::collection($post->comments()->paginate(10));
    }

    public function store(CommentRequest $request, Post $post) {
        $comment = $post->comments()->create($request->validated() + ['user_id' => auth()->id()]);
        return new CommentResource($comment);
    }

    public function show(Post $post, Comment $comment) {
        return new CommentResource($comment);
    }

    public function update(CommentRequest $request, Post $post, Comment $comment) {
        $comment->update($request->validated());
        return new CommentResource($comment);
    }

    public function destroy(Post $post, Comment $comment) {
        $comment->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
