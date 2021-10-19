<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

use App\Http\Resources\PostResource;

use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return $this->successResponse(PostResource::collection($posts), 'Post Succesfully Retrieved');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'content' => 'required'
        ]);

        if($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors());
        }

        $post = Post::create($input);

        return $this->successResponse(new PostResource($post), 'Post Succesfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if(is_null($post)) {
            return $this->errorResponse('Post Not Found');
        }

        return $this->successResponse(new PostResource($post), 'Post Succesfully Retrieved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'content' => 'required'
        ]);

        if($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors());
        }

        $post->title = $input['title'];
        $post->content = $input['content'];
        $post->save();

        return $this->successResponse(new PostResource($post), 'Post Succesfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return $this->successResponse( [], 'Post Succesfully Created');
    }
}
