<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'code',
        'borrowed_at',
        'due_at',
        'returned_at',
        'user_id',
        'fine',
        'note',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_at' => 'date',
        'returned_at' => 'date',
    ];
    protected $table = 'loans';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    // Dibuat oleh siapa
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Diedit oleh siapa terakhir
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function bookLoans()
    {
        return $this->hasMany(BookLoan::class, 'loan_id');
    }
}
