<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'description',
        'category',
        'expense_date'
    ];

    protected $casts = [
        'expense_date' => 'date:Y-m-d',
        'amount' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 