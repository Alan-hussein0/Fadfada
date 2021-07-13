<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      //  return parent::toArray($request);
      return [
        'id'=>$this->id,
        'first_name'=>$this->first_name,
        'second_name'=>$this->second_name,
        'image'=>$this->image,
        'address'=>$this->address,
        'gender'=>$this->gender,
        'phone'=>$this->phone,
        'bio'=>$this->bio,
        'date_of_birth'=>$this->date_of_birth,

        'created_at'=>$this->created_at->format('d/m/y'),
        'updated_at'=>$this->updated_at->format('d/m/y'),
    ];
    }
}
