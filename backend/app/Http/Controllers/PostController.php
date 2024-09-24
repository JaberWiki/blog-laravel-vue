<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Response;

class PostController extends Controller {
    public function index() {
        return PostResource::collection(Post::paginate(10));
    }

    public function store(PostRequest $request) {
        $post = Post::create($request->validated() + ['user_id' => auth()->id()]);
        return new PostResource($post);
    }

    public function show(Post $post) {
        return new PostResource($post);
    }

    public function update(PostRequest $request, Post $post) {
        $post->update($request->validated());
        return new PostResource($post);
    }

    public function destroy(Post $post) {
        $post->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
