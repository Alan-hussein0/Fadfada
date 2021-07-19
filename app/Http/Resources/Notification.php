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

            'user_id'=>$this->user_id,
            'post_id'=>$this->post_id,
            'like_id'=>$this->like_id,
            'comment_id'=>$this->comment_id,
            'first_name'=>$this->user->profile->first_name,
            'second_name'=>$this->user->profile->second_name,
            'description'=>$this->description,
            'from_user_id'=>$this->from_user_id,
            'created_at'=>$this->created_at->format('d/m/y'),
            'updated_at'=>$this->updated_at->format('d/m/y'),
        ];
    }
}
