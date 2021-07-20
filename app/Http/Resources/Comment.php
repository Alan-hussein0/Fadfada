<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
            'parent_id'=>$this->parent_id,
            'description'=>$this->description,
            'first_name'=>$this->user->profile->first_name,
            'second_name'=>$this->user->profile->second_name,
            'image'=>$this->user->profile->image,
            'created_at'=>$this->created_at->format('d/m/y h:m:s'),
            'updated_at'=>$this->updated_at->format('d/m/y h:m:s'),
        ];
    }
}
