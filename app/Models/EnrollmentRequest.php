<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

use App\Models\Student;
use App\Models\Course;

#[Fillable(['user_id', 'course_id', 'status', 'reviewedBy'])]
class EnrollmentRequest extends Model
{
    public function student()
    {
        return $this->belongsTo(Student::class);
    }   

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewedBy');
    }
}
