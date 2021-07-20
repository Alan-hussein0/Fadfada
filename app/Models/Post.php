<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'image',
        'status',
        'user_id',
        'like_number',
        'comment_number'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }


    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->whereNull('parent_id');
    }

}
