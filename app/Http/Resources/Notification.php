<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Notification extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'post_id'=>$this->post_id,
            'like_id'=>$this->like_id,
            'comment_id'=>$this->comment_id,
            'first_name'=>$this->first_name,
            'second_name'=>$this->second_name,
            'image'=>$this->image,
            'description'=>$this->description,
            'from_user_id'=>$this->from_user_id,
            'seen'=>$this->seen,
            'created_at'=>$this->created_at->format('d/m/y/ h:m:s'),
            'updated_at'=>$this->updated_at->format('d/m/y h:m:s'),
        ];
    }
}
