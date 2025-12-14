<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrolment extends Model
{
    public $incrementing = false;

    protected $table = 'enrolments';

    protected $fillable = [
        'learner_id',
        'course_id',
        'progress',
    ];

    protected $casts = [
        'progress' => 'decimal:2',
    ];

   
    public function learner(): BelongsTo
    {
        return $this->belongsTo(Learner::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}