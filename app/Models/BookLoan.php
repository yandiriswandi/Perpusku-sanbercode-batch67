<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
    protected $fillable =['code','user_id','loan_id','book_id','total'];

    protected $table ='book_loans';

      public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
