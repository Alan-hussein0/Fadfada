<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from_user_id',
        'description',
        'post_id',
        'like_id',
        'comment',
        'image',
        'first_name',
        'second_name'
    ];

public function user()
{
    return $this->belongsTo('App\Models\User');
}
}
