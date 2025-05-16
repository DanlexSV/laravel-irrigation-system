<?php

namespace App\Http\Controllers\Devices;

use App\Http\Requests\StoreDeviceRequest;
use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeviceController extends Controller
{
	public function index()
    {
		$user = Auth::user();

        $devices = Device::where('user_id', $user->id)->get();

        return Inertia::render('Device/Index', [
            'devices' => $devices,
        ]);
    }

	public function create()
    {
		return Inertia::render('Device/Create');
    }

	public function store(StoreDeviceRequest $request)
	{
		foreach ($request->mac_addresses as $mac) {
			Device::create([
				'user_id' => auth()->id(),
				'mac_address' => $mac,
			]);
		}

		return redirect()->route('device.index')->with('success', 'Dispositivos vinculados correctamente.');
	}
}
