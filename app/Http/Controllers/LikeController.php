<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Like as ResourcesLike;
use App\Models\Notification;
use App\Models\Post;



class LikeController extends BaseController
{

    public function store(Request $request)
    {
        $input = $request->all();
        //validator must be more than one value because it's array
        $validator = Validator::make($input,[
            'like'=>['required','boolean'],
            'post_id'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors());
        }
        $user = Auth::user();
        $input['user_id']=$user->id;
        $user_id=$user->id;

        //check if the user was liked the post before
        $errorMessage=[];
        if (Like::where('user_id',$user_id)->where('post_id',$request->post_id)->first()) {
            return $this->sendError('you like this post before',$errorMessage);
        }


        $like =Like::create($input);
        //$post =Post::id($like->post_id);
        $post=Post::where('id',$like->post_id)->first();
        $post['like_number']=$post->like_number+1;
        $post->save();
        Notification::create([
            'user_id'=>$post->user_id,
            'from_user_id'=>$user_id,
            'post_id'=>$post->id,
            'description'=>'like',
            'like_id'=>$like->id,
            'first_name'=>$user->profile->first_name,
            'second_name'=>$user->profile->second_name,
            'image'=>$user->profile->image
        ]);
        return $this->sendResponse(new ResourcesLike($like),'like add successfully');
    }




    // public function update(Request $request)
    // {
    //     $input = $request->all();
    //     $validator = Validator::make($input,[
    //         'like'=>['required','boolean'],
    //         'post_id'=>'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->sendError('validation error', $validator->errors());
    //     }

    //     $like=Like::where('post_id',$request->post_id)->where('user_id',$request->user_id)->first();

    //     if ($like->user_id != Auth::id()) {
    //         return $this->sendError('you dont have rigth',$validator->errors());
    //     }

    //     $like->like=$input['like'];
    //     $like->save();
    //     return $this->sendResponse($like,'updated successfully');
    // }


    public function destroy( $id,Request $request)
    {

        $input = $request->all();
        //validator must be more than one value because it's array
        $validator = Validator::make($input,[
            'like'=>['required','boolean'],
            'post_id'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors());
        }

        $like=Like::where('user_id',$id)->where('post_id',$request->post_id)->first();


        $errorMessage = [];
        if ( $like->user_id != Auth::id()) {
            return $this->sendError('you dont have rights' , $errorMessage);
        }
        $like->delete();
        $post =Post::where('id',$like->post_id)->first();
        $post['like_number']=$post->like_number-1;
        $post->save();
        return $this->sendResponse($like, 'like deleted Successfully!' );

    }
}
