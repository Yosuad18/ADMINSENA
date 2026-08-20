<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apprentice extends Model
{
    protected $fillable = ['name', 'course_id', 'computer_id'];

    public function course(): BelongsTo { return $this->belongsTo(Course::class); }
    public function computer(): BelongsTo { return $this->belongsTo(Computer::class); }
}
