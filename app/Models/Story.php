<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable =[
        'text',
        'image',
        'video',
        'processed',
        'status',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
