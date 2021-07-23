<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id','to_user_id','text'
    ];

    public function follower()
    {
        return $this->belongsToMany(Follower::class, 'from_user_id', 'to_user_id');
    }

}
