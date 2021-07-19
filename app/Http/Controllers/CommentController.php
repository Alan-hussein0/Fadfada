<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Comment as CommentResource;
use App\Models\Notification;
use App\Models\Post;

class CommentController extends BaseController
{




    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'description'=>'required',
             'post_id'=>'required',
             //'parent_id'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors());
        }

        $post = Post::where('id',$request->post_id)->first();
        $user = Auth::user();
        $input['user_id'] = $user->id;
        $comment = Comment::create($input);
        Notification::create([
            'user_id'=>$post->user_id,
            'from_user_id'=>$user->id,
            'post_id'=>$request->post_id,
            'description'=>'comment on your post',
            'comment_id'=>$comment->id,
        ]);
        return $this->sendResponse($comment,'Comment created successfully!');
    }

    public function show($id)
    {
        $comment = Comment::where('post_id',$id)->get();
        if (count($comment)==0) {
            return $this->sendError('comment not found!');
        }
        return $this->sendResponse(CommentResource::collection($comment),'Comment retireved Successfully!');
    }


    public function update(Request $request,Comment $comment)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'description'=>'required',
            'post_id'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('validation error',$validator->errors());
        }
        if ($comment->user_id != Auth::id()) {
            return $this->sendError('you do not have reigths ',$validator->errors());
        }

        $comment->description = $input['description'];
        $comment->save();
        return $this->sendResponse(new CommentResource($comment),'Comment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $errorMessage = [];
        if ( $comment->user_id != Auth::id()) {
            return $this->sendError('you dont have rights' , $errorMessage);
        }
        $comment->delete();
        return $this->sendResponse(new CommentResource($comment), 'Comment deleted Successfully!' );

    }
}
