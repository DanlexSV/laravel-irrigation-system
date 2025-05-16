<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
		return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
	public function rules(): array
	{
		return [
            'devices'                     => 'required|array|min:1',
			'devices.*.mac'               => [
            	'required',
				'regex:/^([0-9A-F]{2}:){5}[0-9A-F]{2}$/i',
				'distinct',
				'unique:devices,mac_address',
			],
            'devices.*.planta_id'         => 'required|integer|exists:floors,id',
            'devices.*.water_frequency'   => 'required|integer|min:1',
            'devices.*.sunlight'          => 'required|in:Nula,Baja,Media,Alta',
        ];
	}
}
