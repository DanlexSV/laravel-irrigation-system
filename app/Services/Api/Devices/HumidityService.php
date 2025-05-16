<?php

namespace App\Services\Api\Devices;

use App\Models\Device;
use App\Models\HumidityReading;
use Illuminate\Support\Facades\Log;

class HumidityService
{
	public function processHumidityData(array $data): array
	{
		$device = Device::where('mac_address', $data['mac_address'])->first();

		if (!$device) {
			return [
				'status'      => 'error',
				'message'     => 'Dispositivo no encontrado. Por favor, regístralo primero.',
				'status_code' => 404,
			];
		}

		HumidityReading::create([
			'device_id'   => $device->id,
			'humidity'    => $data['humidity'],
			'measured_at' => now(),
		]);

		$device->update([
			'last_humidity'    => $data['humidity'],
			'last_measured_at' => now(),
		]);

		return [
			'status'      => 'success',
			'message'     => 'Lectura registrada correctamente.',
			'status_code' => 201,
		];
	}
}
