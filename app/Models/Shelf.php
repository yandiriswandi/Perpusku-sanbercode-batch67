<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;
    protected $fillable =['name','code','description'];

    protected $table = 'shelfs';

      public function book()
    {
        return $this->hasMany(Book::class, 'shelf_id');
    }
}
