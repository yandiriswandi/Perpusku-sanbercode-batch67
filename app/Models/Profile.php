<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'place_of_birth',
        'date_of_birth',
        'bio',
        'address',
        'phone_number',
        'gender',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
