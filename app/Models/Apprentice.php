<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Apprentice extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'document',
        'address',
        'estrato',
        'email',
        'cell',
        'course_id',
        'computer_id',
    ];

    protected $casts = ['estrato' => 'integer'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function computer(): BelongsTo
    {
        return $this->belongsTo(Computer::class);
    }
}
