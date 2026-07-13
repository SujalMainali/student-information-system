<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    )
    {}
    public function index()
    {
        $user = auth()->user();

        $dashboard = match ($user->role) {
            'admin' => $this->dashboardService->getAdminDashboard($user),
            'staff' => $this->dashboardService->getStaffDashboard($user),
            'student' => $this->dashboardService->getStudentDashboard($user),
            default => [],
        };

        return view('dashboard.app', $dashboard);
    }


}