<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Course;

class EnrollmentRequest extends Model
{
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
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
