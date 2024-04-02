<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Deal;
use App\Models\Location;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardHomeController extends Controller
{
    public function index()
    {

        $todayDate = Carbon::today()->toDateString();

        $totalCustomers = User::where('role_id', Role::getRole('Customer')->id)->count();
        $totalEmployees = User::where('role_id', Role::getRole('Employee')->id)->count();

        $totalServicesActive = Service::where('is_hidden', 0)->count();
        $totalServices = Service::count();

        $totalUpcomingDeals = Deal::where('start_date', '<', $todayDate)->count();
        $totalOngoingDeals = Deal::where('start_date', '<=', $todayDate)->where('end_date', '>=', $todayDate)->count();

        // dd($totalCustomers, $totalEmployees, $totalServicesActive, $totalServices, $totalUpcommingDeals, $totalOngoingDeals);

        $totalUpcomingAppointments = Appointment::where('date', '>', $todayDate)->count();
        $todaysAppointments = Appointment::where('date', $todayDate)->count();
        $tommorowsAppointments = Appointment::where('date', Carbon::today()->addDay()->toDateTime())->count();

        $bookingRevenueThisMonth = Appointment::where('created_at', '>', Carbon::today()->subMonth()->toDateTime())->where('status', '!=', 0)->sum('total');
        $bookingRevenueLastMonth = Appointment::where('created_at', '>', Carbon::today()->subMonths(2)->toDateTime())->where('created_at', '<', Carbon::today()->subMonth()->toDateTime())->where('status', '!=', 0)->sum('total');

        $percentageRevenueChangeLastMonth = 0;
        if ($bookingRevenueLastMonth != 0) {
            $percentageRevenueChangeLastMonth = ($bookingRevenueThisMonth - $bookingRevenueLastMonth) / $bookingRevenueLastMonth * 100;
        } else {
            $percentageRevenueChangeLastMonth = 100;
        }


        $todaysSchedule = Appointment::orderBy('start_time', 'asc')
                ->where('date', $todayDate)
                ->where('status', '!=', 0)
                ->orderBy('date', 'asc')
                ->where('status', '!=', 0)
                ->with('service', 'creator')
                ->get();

        $tommorowsSchedule = Appointment::orderBy('start_time', 'asc')
                ->where('date', Carbon::today()->addDay()->toDateTime())
                ->where('status', '!=', 0)
                ->orderBy('date', 'asc')
                ->where('status', '!=', 0)
                ->with('service', 'creator')
                ->get();

        $locations = Location::all();





        return view('dashboard.admin-employee', [
            'totalCustomers' => $totalCustomers,
            'totalEmployees' => $totalEmployees,
            'totalServicesActive' => $totalServicesActive,
            'totalServices' => $totalServices,
            'totalUpcomingDeals' => $totalUpcomingDeals,
            'totalOngoingDeals' => $totalOngoingDeals,
            'totalUpcomingAppointments' => $totalUpcomingAppointments,
            'todaysAppointments' => $todaysAppointments,
            'tommorowsAppointments' => $tommorowsAppointments,
            'bookingRevenueThisMonth' => $bookingRevenueThisMonth,

//            'bookingRevenueLastMonth' => $bookingRevenueLastMonth,
            'percentageRevenueChangeLastMonth' => $percentageRevenueChangeLastMonth,



            'todaysSchedule' => $todaysSchedule,
            'tomorrowsSchedule' => $tommorowsSchedule,
            'locations' => $locations,

        ]);
    }
}
