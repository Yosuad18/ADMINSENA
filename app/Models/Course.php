<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'area_id', 'training_center_id'];

    public function area(): BelongsTo { return $this->belongsTo(Area::class); }
    public function trainingCenter(): BelongsTo { return $this->belongsTo(TrainingCenter::class); }
    public function apprentices(): HasMany { return $this->hasMany(Apprentice::class); }
    public function teachers(): BelongsToMany { return $this->belongsToMany(Teacher::class, 'course_teachers'); }
}
