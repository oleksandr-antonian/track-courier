<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourierRequest extends FormRequest
{

    public function rules(): array
    {
        $courierId = $this->route('courier');
        return [
            'first_name' => 'required|string|max:120',
            'last_name' => 'required|string|max:120',
            'email' => 'required|email|max:255|unique:couriers,email,' . $courierId,
            'phone' => 'required|string|max:20|unique:couriers,phone,' . $courierId,
            'city_id' => 'required|integer|exists:cities,id',
            'transport_type' => 'required|integer',
            'availability_status' => 'required|integer',
        ];
    }
}
