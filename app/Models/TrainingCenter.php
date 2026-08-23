<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingCenter extends Model
{
    protected $fillable = ['name', 'address'];

    public function teachers(): HasMany { return $this->hasMany(Teacher::class); }
    public function courses(): HasMany { return $this->hasMany(Course::class); }
}
