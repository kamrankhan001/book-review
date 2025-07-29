<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        return inertia('Dashboard', [
            'books' => $this->dashboardService->getUserBooks($request),
            'reviews' => $this->dashboardService->getUserReviews(),
            'filters' => $request->only('search'),
        ]);
    }
}
