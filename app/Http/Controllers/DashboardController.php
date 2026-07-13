<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Models\User;

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
            User::ROLE_ADMIN => $this->dashboardService->getAdminDashboard($user),
            User::ROLE_STAFF => $this->dashboardService->getStaffDashboard($user),
            User::ROLE_STUDENT => $this->dashboardService->getStudentDashboard($user),
            default => [],
        };

        return view('dashboard.app', $dashboard);
    }


}