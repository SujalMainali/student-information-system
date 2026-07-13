<?php

namespace App\Services;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    public function getAdminDashboard(User $user): array
    {
        $data = $this->buildBaseDashboard($user);

        $data += [

            'totalStudents' => Student::count(),

            'totalCourses' => Course::count(),

            'totalEnrollments' => DB::table('course_student')->count(),

        ];

        return $data;
    }

    public function getStaffDashboard(User $user): array
    {
        $data = $this->buildBaseDashboard($user);

        $data += [

            'totalStudents' => Student::count(),

            'totalCourses' => Course::count(),

            'totalEnrollments' => DB::table('course_student')->count(),

        ];

        return $data;
    }

    public function getStudentDashboard(User $user): array
    {
        $data = $this->buildBaseDashboard($user);

        $student = $user->student;

        if (!$student) {
            
            $data += [
                'enrolledCourses' => 0,
                'currentCredits' => 0,
                'upcomingClasses' => 0,
                'upcomingExams' => 0,
                'pendingRequests' => 0,
            ];

            return $data;
        }

        $courses = $student->courses()->get();

        $data += [

            'enrolledCourses' => $courses->count(),

            'currentCredits' => (int) $courses->sum('credits'),

            'upcomingClasses' => $courses->count(),

            'upcomingExams' => 0,

            'pendingRequests' => $student->enrollmentRequests()->where('status', 'pending')->count(),

        ];

        return $data;
    }

    private function buildBaseDashboard(User $user): array
    {
        return [
            'userName' => $user->name,

            'greeting' => $this->getGreeting(),

            'roleLabel' => $this->getRoleLabel($user),

            'isAdmin' => $user->isAdmin(),

            'isStaff' => $user->isStaff(),

            'isStudent' => $user->isStudent(),
        ];
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

    private function getRoleLabel(User $user): string
    {
        $roleLabel = match ($user->role) {
            'admin' => 'Administrator Dashboard',
            'staff' => 'Staff Dashboard',
            default => 'Student Dashboard',
        };
        return $roleLabel;        
    }
}