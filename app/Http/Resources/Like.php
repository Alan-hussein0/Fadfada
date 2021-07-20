<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Like extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'post_id'=>$this->post_id,
            'user_id'=>$this->user_id,
            'like'=>$this->like,
            'created_at'=>$this->created_at->format('d/m/y h:m:s'),
            'updated_at'=>$this->updated_at->format('d/m/y h:m:s'),
        ];


    }
}
