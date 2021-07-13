<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    use HasFactory;
    protected $fillable = [
        'profile_id','education'
    ];

    public function profile()
    {
        return $this->belongsTo('App\Models\profile','profile_id');;
    }
}
