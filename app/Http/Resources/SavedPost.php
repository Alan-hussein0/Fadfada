<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SavedPost extends JsonResource
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
            //'description'=>$this->post->description,
            'created_at'=>$this->created_at->format('d/m/y'),
            'updated_at'=>$this->updated_at->format('d/m/y'),
        ];
    }
}
