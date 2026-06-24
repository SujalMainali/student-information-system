<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Student;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
            ->withPivot('enrolled_at')
            ->withTimestamps();
    }
}
