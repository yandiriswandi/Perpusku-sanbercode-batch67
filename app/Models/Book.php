<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'code', 'author', 'publisher', 'year_published', 'isbn', 'category_id', 'shelf_id', 'stock', 'description', 'cover_image'];
    protected $table = 'books';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function shelf()
    {
        return $this->belongsTo(Shelf::class, 'shelf_id', 'id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'book_id');
    }

}
