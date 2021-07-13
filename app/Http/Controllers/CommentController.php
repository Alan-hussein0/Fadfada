<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Comment as CommentResource;

class CommentController extends BaseController
{




    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'description'=>'required',
             'post_id'=>'required',
             'parent_id'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors());
        }

        $user = Auth::user();
        $input['user_id'] = $user->id;
        $comment = Comment::create($input);
        return $this->sendResponse($comment,'Comment created successfully!');
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
