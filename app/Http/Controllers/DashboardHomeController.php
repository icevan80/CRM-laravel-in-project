<?php

namespace App\Http\Controllers;

class DashboardHomeController extends Controller
{
    public function index()
    {

        if (auth()->user()->hasPermission('new_style_access')) {
            return view('dashboard.testim');
        } else if (auth()->user()->hasPermission('admin_dashboard_access')) {
            $adminDashboardHomeController = new AdminDashboardHomeController();
            return $adminDashboardHomeController->index();
        } else if (auth()->user()->hasPermission('customer_dashboard_access')) {
            return view('dashboard.customer');
        } else {
            return redirect()->route('home')->with('error', 'You are not authorized to perform this action.');
        }
    }
}
