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
			'mac_addresses' => ['required', 'array'],
			'mac_addresses.*' => [
				'required',
				'distinct',
				'regex:/^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/',
				'unique:devices,mac_address',
			],
		];
	}
}
