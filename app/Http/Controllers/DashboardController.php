<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    /**
     * Dashboard controller
     */
    public function index()
    {
        $isAdmin = auth()->user()->is_admin;

        return view('home', compact('isAdmin'));
    }
}
