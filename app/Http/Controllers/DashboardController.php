<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $roleLabel = match ($user->role) {
            'admin' => 'Administrator Dashboard',
            'staff' => 'Staff Dashboard',
            default => 'Student Dashboard',
        };

        $greeting = $this->getGreeting();

        $data = [
            'userName' => $user->name,
            'roleLabel' => $roleLabel,
            'greeting' => $greeting,
            'isAdmin' => $user->isAdmin(),
            'isStaff' => $user->isStaff(),
            'isStudent' => $user->isStudent(),
        ];

        if ($user->isAdmin() || $user->isStaff()) {
            $data['totalStudents'] = Student::count();
            $data['totalCourses'] = Course::count();
            $data['totalEnrollments'] = DB::table('course_student')->count();
        }

        if ($user->isStudent()) {
            $student = $user->student;

            if ($student) {
                $enrolledCourses = $student->courses()->get();
                $entollmentRequests = $student->enrollmentRequests()->get();
                $data['enrolledCourses'] = $enrolledCourses->count();
                $data['currentCredits'] = (int) $enrolledCourses->sum('credits');
                $data['upcomingClasses'] = $enrolledCourses->count();
                $data['upcomingExams'] = 0;
                $data['pendingRequests'] = $entollmentRequests->count();
            } else {
                $data['enrolledCourses'] = 0;
                $data['currentCredits'] = 0;
                $data['upcomingClasses'] = 0;
                $data['upcomingExams'] = 0;
                $data['pendingRequests'] = 0;
            }
        }

        return view('dashboard.app', $data);
    }

    private function getGreeting(): string
    {
        $hour = now()->hour;

        if ($hour < 12) {
            return 'Good morning';
        }
        if ($hour < 17) {
            return 'Good afternoon';
        }
        return 'Good evening';
    }
}