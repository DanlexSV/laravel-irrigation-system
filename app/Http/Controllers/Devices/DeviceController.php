<?php

namespace App\Http\Controllers\Devices;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceRequest;
use App\Services\Devices\DeviceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeviceController extends Controller
{
	public function __construct(private DeviceService $deviceService) {}

	public function index()
    {
		$devices = Auth::user()
			->devices()
			->with('floor')
			->get();

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
        $this->deviceService->createDevices(
            auth()->id(),
            $request->input('devices', [])
        );

		return to_route('device.index')
			->with('success', 'Dispositivos vinculados correctamente.');
    }
}
