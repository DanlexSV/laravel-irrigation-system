<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index()
    {
        $devices = $this->queryDevices();
        return Inertia::render('Dashboard', ['devices' => $devices]);
    }

    public function data()
    {
        return $this->queryDevices();
    }

    private function queryDevices()
    {
        return Auth::user()
            ->devices()
            ->whereNotNull('last_humidity')
			->select('id', 'mac_address', 'last_humidity')
            ->get();
    }
}
