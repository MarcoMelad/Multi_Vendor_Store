<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = "Marco Milad";
        return view('dashboard.index', compact('user'));
    }
}
