<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name','second_name','image','address','gender',
        'phone','bio','date_of_birth','user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id' );
    }
    public function education()
    {
        return $this->hasMany('App\Models\Education');
    }
}
