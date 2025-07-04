<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'description'];

    protected $table = 'categories';
    public function book()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}
