<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'date',
        'value'
    ];

        protected $casts = [
            'date' => 'datetime',
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
