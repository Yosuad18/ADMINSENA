<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['name', 'area_id', 'training_center_id'];

    public function area(): BelongsTo { return $this->belongsTo(Area::class); }
    public function trainingCenter(): BelongsTo { return $this->belongsTo(TrainingCenter::class); }
    public function courses(): BelongsToMany { return $this->belongsToMany(Course::class, 'course_teachers'); }
}
