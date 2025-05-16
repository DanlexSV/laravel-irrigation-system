<?php

namespace App\Http\Controllers\Api\Devices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\Devices\HumidityService;

class HumidityController extends Controller
{
    protected HumidityService $service;

    public function __construct(HumidityService $service)
    {
        $this->service = $service;
    }

    public function check()
    {
        return response()->json(['message' => 'API Humidity Online'], 200);
    }

    public function humidity(Request $request)
    {
        $data = $request->validate([
            'mac_address' => 'required|string',
            'humidity'    => 'required|integer|min:0|max:100',
        ]);

        $result = $this->service->processHumidityData($data);
		$code = $result['status_code'] ?? 200;

		return response()->json([
			'status'  => $result['status'],
			'message' => $result['message'],
		], $code);
    }
}
