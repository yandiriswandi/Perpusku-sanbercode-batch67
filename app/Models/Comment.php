<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'book_id', 'content'];
    protected $table = 'comments';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
