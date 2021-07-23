<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'form_user_id', 'to_user_id');
    }

    /**
     * The roles that belong to the Follower
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function message()
    {
        return $this->belongsToMany(Message::class, 'from_user_id', 'to_user_id');
    }
}
