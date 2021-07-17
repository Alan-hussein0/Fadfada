<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Post as PostResource;

class PostController extends BaseController
{
    public function index()
    {
        $post = Post::all();
        return $this->sendResponse(PostResource::collection($post),'posts retrieved successfully');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'text'=>'required',
            // 'image'=>'required',
            'status'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors());
        }

        if ($request->image != null) {
            $photo = $request->image;
            $newPhoto = time().$photo->getClientOriginalName();
            $photo->move('post/image',$newPhoto);

            $input['image']='post/image/'.$newPhoto;
            }

        $user = Auth::user();
        $input['user_id'] = $user->id;
        $post = Post::create($input);
        return $this->sendResponse($post,'post created successfully!');
    }

    public function show($id)
    {
        $post = Post::where('user_id',$id)->get();
        if (count($post)==0) {
            return $this->sendError('Post not found!');
        }
        return $this->sendResponse(PostResource::collection($post),'Post retrieved Successfully!');
    }


    public function update(Request $request, Post $post)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'text'=>'required',
           // 'image'=>'required',
            'status'=>'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error' , $validator->errors());
        }

        if ($request->image != null) {
        $photo = $request->image;
        $newPhoto = time().$photo->getClientOriginalName();
        $photo->move('post/image',$newPhoto);
        }

        if ( $post->user_id != Auth::id()) {
            return $this->sendError('you dont have rights' , $validator->errors());
        }

        $post->text = $input['text'];

        if ($request->image != null) {
            $post->image = 'post/image/'.$newPhoto;
        }

        $post->status = $input['status'];
        $post->save();

        return $this->sendResponse(new PostResource($post), 'Post updated Successfully!' );

    }


    public function destroy(Post $post)
    {

        $errorMessage = [] ;

        if ( $post->user_id != Auth::id()) {
            return $this->sendError('you dont have rights' , $errorMessage);
        }

        $post->delete();
        return $this->sendResponse(new PostResource($post), 'Post deleted Successfully!' );

    }
}
