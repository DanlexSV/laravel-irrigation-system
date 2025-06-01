<?php

namespace App\Http\Controllers\Api\Devices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\Devices\WateringService;

class WateringController extends Controller
{
    protected WateringService $service;

    public function __construct(WateringService $service)
    {
        $this->service = $service;
    }

	public function checkWatering(Request $request)
	{
		$data = $request->validate([
			'mac_address' => 'required|string',
		]);

		$result = $this->service->getLastWateringInfo($data['mac_address']);

		if ($result['status'] === 'error') {
			return response()->json($result, $result['status_code']);
		}

		$device = $result['device'];
		$lastEvent = $result['last_event'];

		$evaluation = $this->service->shouldWaterNow($device, $lastEvent);

		return response()->json($evaluation, $evaluation['status_code']);
	}

	public function registerAutoWatering(Request $request)
	{
		$data = $request->validate([
			'mac_address'      => 'required|string',
			'duration_seconds' => 'required|integer|min:1',
		]);

		$result = $this->service->registerAutoWatering($data);

		return response()->json($result, $result['status_code']);
	}
}
