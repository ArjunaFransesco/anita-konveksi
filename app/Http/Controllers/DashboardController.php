<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function ownerDashboard()
    {
        return view('dashboard.owner');
    }

    public function adminDashboard()
    {
        return view('dashboard.admin');
    }

    public function kasirDashboard()
    {
        return view('dashboard.kasir');
    }
}