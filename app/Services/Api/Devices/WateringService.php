<?php

namespace App\Services\Api\Devices;

use Carbon\Carbon;
use App\Models\Floor;
use App\Models\Device;
use App\Models\WateringEvent;
use App\Models\HumidityReading;

class WateringService
{
	public function getLastWateringInfo(string $macAddress): array
	{
		$device = Device::where('mac_address', $macAddress)->first();

		if (!$device) {
			return [
				'status'      => 'error',
				'message'     => 'Dispositivo no encontrado.',
				'status_code' => 404,
			];
		}

		$lastEvent = $device->wateringEvents()->latest('watered_at')->first();

		return [
			'status'           => 'ok',
			'device'           => $device,
			'last_event'       => $lastEvent,
			'status_code'      => 200,
		];
	}
	
	public function shouldWaterNow(Device $device, ?WateringEvent $lastEvent): array
	{
		$lastReading = $device->humidityReadings()->latest('measured_at')->first();

		if (!$lastReading) {
			return [
				'status'         => 'error',
				'message'        => 'No hay lecturas de humedad registradas.',
				'status_code'    => 404,
			];
		}

		$now = now();
		$humidity = $lastReading->humidity;
		$sunlight = strtolower($device->sunlight);

		$rules = [
			'alta'  => ['humidity_threshold' => 20, 'tolerance_percent' => 25],
			'media' => ['humidity_threshold' => 20, 'tolerance_percent' => 15],
			'baja'  => ['humidity_threshold' => 15, 'tolerance_percent' => 10],
		];

		$rule = $rules[$sunlight] ?? $rules['media'];

		$humidityThreshold = $rule['humidity_threshold'];
		$tolerancePercent = $rule['tolerance_percent'];

		$shouldWater = false;
		$reason = 'Condiciones aún no cumplidas';
		$daysSinceLast = null;

		if ($humidity < $humidityThreshold) {
			if (!$lastEvent) {
				$shouldWater = true;
				$reason = 'Nunca se ha regado y la humedad está por debajo del umbral';
			} else {
				$lastWatered = Carbon::parse($lastEvent->watered_at);
				$daysSinceLast = $lastWatered->diffInDays($now);

				$allowedToleranceDays = intval(($device->water_frequency ?? 0) * ($tolerancePercent / 100));

				if ($daysSinceLast >= $allowedToleranceDays) {
					$shouldWater = true;
					$reason = 'Se ha superado el margen de días permitido y la humedad está baja';
				} else {
					$reason = 'La humedad está baja, pero aún dentro del margen de días permitido';
				}
			}
		} else {
			$reason = 'La humedad es suficiente';
		}

		return [
			'status'            => 'ok',
			'should_water'      => $shouldWater,
			'reason'            => $reason,
			'last_watered_at'   => $lastEvent?->watered_at,
			'days_since'        => $daysSinceLast,
			'last_humidity'     => $humidity,
			'sunlight'          => $device->sunlight,
			'duration_seconds'  => 9000,
			'status_code'       => 200,
		];
	}

	public function registerAutoWatering(array $data): array
	{
		$device = Device::where('mac_address', $data['mac_address'])->first();

		if (!$device) {
			return [
				'status'      => 'error',
				'message'     => 'Dispositivo no encontrado.',
				'status_code' => 404,
			];
		}

		$device->wateringEvents()->create([
			'watered_at'       => now(),
			'duration_seconds' => $data['duration_seconds'],
			'source'           => 'auto',
			'note'             => null,
		]);

		return [
			'status'      => 'success',
			'message'     => 'Riego automático registrado.',
			'status_code' => 201,
		];
	}
}
