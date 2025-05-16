<?php

namespace App\Services\Devices;

use App\Models\Device;
use Illuminate\Support\Collection;

class DeviceService
{
    public function createDevices(int $userId, array $devices): void
    {
        foreach ($devices as $device) {
			Device::firstOrCreate(
				['mac_address' => $device['mac']],
				[
					'user_id'         => $userId,
					'floor_id'        => $device['planta_id'],
					'water_frequency' => $device['water_frequency'],
					'sunlight'        => $device['sunlight'],
				]
			);
        }
    }
}
