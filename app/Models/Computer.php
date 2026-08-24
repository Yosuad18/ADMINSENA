<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Computer extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',      // Corregido según tu migración (en lugar de serial_number)
        'brand',
    ];

    public function apprentice(): HasOne {
        return $this->hasOne(Apprentice::class);
        }
}
