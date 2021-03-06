<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
       return [
           'id'=>$this->id,
           'user_id'=>$this->user_id,
           'text'=>$this->text,
           'image'=>$this->image,
           'status'=>$this->status,
           'like_number'=>$this->like_number,
           'comment_number'=>$this->comment_number,
           //'name'=>$this->user->name,
           'tags'=>$this->tags,
           'first_name'=>$this->user->profile->first_name,
           'second_name'=>$this->user->profile->second_name,
           'image_profile'=>$this->user->profile->image,
           'created_at'=>$this->created_at->format('d/m/y h:m:s'),
           'updated_at'=>$this->updated_at->format('d/m/y h:m:s'),
       ];
    }
}
