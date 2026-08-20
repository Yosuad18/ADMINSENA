<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    protected $fillable = ['serial_number', 'brand'];

    public function apprentice(): HasOne { return $this->hasOne(Apprentice::class); }
}
