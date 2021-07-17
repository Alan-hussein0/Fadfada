<?php

namespace App\Http\Controllers;

use App\Models\SavedPost;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Profile;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\SavedPost as SavedPostResource;

class SavedPostController extends BaseController
{


    public function store(Request $request)
    {
        $input =$request->all();
        //to use Validator must be more than one values to accept
        $this->validate($request,[
            'post_id'=>'required'
        ]);
//it's should be an array to use fails function
        // if ($validator->fails()) {
        //     return $this->sendError('validate error',$validator->errors());
        // }


        $user = Auth::user();
        $input['user_id']=$user->id;
        // $user_id=$user->id;
        // $errorMessage=[];
        // if (Profile::where('user_id',$user_id)->where('post_id',$request->post_id)->first()) {
        //     return $this->sendError('you saved this post before',$errorMessage);
        // }

        // $profile=Profile::where('id',$like->post_id)->first();
        // $profile['like_number']=$profile->saved_post_number+1;
        // $profile->save();
        $message=[];
        if (SavedPost::where('user_id',$user->id)->where('post_id',$request->post_id)->first()) {
            return $this->sendError('you saved this post before',$message);
        }

        $savedPost = SavedPost::create($input);

        return $this->sendResponse(new SavedPostResource($savedPost),'add new post to saved post');

        //we use savedpostresource::collecation when we return a collection of data other wies use new
    }

    public function show($id)
    {
        $savedPost=SavedPost::where('user_id',$id)->get();
        $message=[];
        if (Auth::id()!=$id) {
            return $this->sendError('you don not have right',$message);
        }
        if ($savedPost==null) {
            return $this->sendError('there is no seved post',$message);
        }
        return $this->sendResponse(SavedPostResource::collection($savedPost),'seved post retireved Successfully!');
    }


    public function destroy(Request $request, $id)
    {
        $input = $request->all();
        //validator must be more than one value because it's array
        $this->validate($request,[
            'post_id'=>'required'
        ]);
        // if ($validator->fails()) {
        //     return $this->sendError('Validate Error',$validator->errors());
        // }
        $message=[];
        if (!SavedPost::where('user_id',Auth::id())->where('post_id',$request->post_id)->first()) {
            return $this->sendError('this post not saved',$message);
        }

        $savedPost=SavedPost::where('user_id',$id)->where('post_id',$request->post_id)->first();


        $errorMessage = [];
        if ( $savedPost->user_id != Auth::id()) {
            return $this->sendError('you dont have rights' , $errorMessage);
        }
        $savedPost->delete();
        // $profile =Profile::where('user_id',$savedPost->user_id)->first();
        // $Profile['saved_post_number']=$profile->saved_post_number-1;
        // $profile->save();
        return $this->sendResponse($savedPost, 'post deleted Successfully!' );

    }
}
