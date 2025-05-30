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
        'category',
        'description',
        'expense_date'
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'integer'
    ];

    public const CATEGORIES = [
        '食費',
        '交通費',
        '住居費',
        '光熱費',
        '通信費',
        '日用品',
        '医療費',
        '教育費',
        '娯楽費',
        'その他'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 