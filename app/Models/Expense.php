<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'date',
        'value',
    ];

    protected $casts = [
        'date' => 'datetime',
        'value' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function formattedValue(): Attribute
    {
        return new Attribute(
            get: fn () => 'R$ '.str_replace('.', ',', (float) $this->value),
        );
    }
}
