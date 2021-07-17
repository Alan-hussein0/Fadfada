<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Story extends JsonResource
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
           'text'=>$this->text,
           'image'=>$this->image,
           'video'=>$this->video,
           'status'=>$this->status,
           'name'=>$this->user->name,
           'first_name'=>$this->user->profile->first_name,
           'second_name'=>$this->user->profile->second_name,
           'created_at'=>$this->created_at->format('d/m/y'),
           'updated_at'=>$this->updated_at->format('d/m/y'),
        ];
    }
}
