<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Story as ResourcesStory;
use Validator;

class StoryController extends BaseController
{

    public function index()
    {
        $story = Story::all();
        return $this->sendResponse(ResourcesStory::collection($story),'all story');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'video'=>'required|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv'
        ]);

        if ($request->image != null) {
            $photo = $request->image;
            $newPhoto = time().$photo->getClientOriginalName();
            $photo->move('story/image',$newPhoto);

            $input['image']='story/image/'.$newPhoto;
            };

        $video = $request->video;
        $newVideo = time().$video->getClientOriginalName();
        $video->move('story/video',$newVideo);

        $input['video']='story/video/'.$newVideo;


        $user = Auth::user();
        $input['user_id']=$user->id;
        $story = Story::create($input);

        return $this->sendResponse(new ResourcesStory($story),'post created successfully!');

    }

    public function show($id)
    {
        $message =[];
        if (!Story::where('user_id',$id)->first()) {
            return $this->sendError('there is no story',$message);
        }
        $story = Story::where('user_id',$id)->get();
        return $this->sendResponse(ResourcesStory::collection($story) ,'Story retireved Successfully!');
    }


    public function update(Request $request, Story $story)
    {
        $input = $request->all();
        $validator=Validator::make($input,[
            // 'video'=>'required|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv',
            'video'=>'required|mimes:video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv',
            'processed'=>['required','boolean']
        ]);

        // video/x-flv
        // MPEG-4          .mp4            video/mp4
        // iPhone Index    .m3u8           application/x-mpegURL
        // iPhone Segment  .ts             video/MP2T
        // 3GP Mobile      .3gp            video/3gpp
        // QuickTime       .mov            video/quicktime
        // A/V Interleave  .avi            video/x-msvideo
        // Windows Media   .wmv            video/x-ms-wmv


        if ($validator->fails()) {
            return $this->sendError('validate error',$validator->errors());
        }

        $story->processed = $input['processed'];

        $video = $request->video;
        $newVideo = time().$video->getClienOriginalName();
        $video->move('story/video_processed',$newVideo);
        $input['video']= 'story/video_processed/'.$newVideo;

        $story->video = $input['video'];
        $story->save();
        return $this->sendResponse(new ResourcesStory($story),'the story processed successfully!');
    }

    // $video = $request->video;
    // $newVideo = time().$video->getClientOriginalName();
    // $video->move('story/video',$newVideo);

    // $input['video']='story/video/'.$newVideo;

    public function destroy(Story $story)
    {
        // $this->validate($request,[
        //     'id'=>'required'
        // ]);
        $message =[];
        if (Auth::id()!=$story->user_id) {
            return $this->sendError('you dont have rights',$message);
        }
        // if (!Story::where('user_id',$story->usre_id)->where('id',$story->id)->first()) {
        //    return $this->sendError('there is no story',$message);
        // }

        $story->delete();
        return $this->sendResponse(new ResourcesStory($story), 'Story deleted Successfully!' );

    }
}
