<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProcessVideo extends JsonResource
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
            'video'=>$this->video,
            'processed'=>$this->processed,
            'token'=>$this->user->createToken('FadFadaSeniorProject')->accessToken,
        ];
    }
}
