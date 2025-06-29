<?php

namespace App\Http\Requests\TravelOrder;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'travel_order_status_id' => 'required|min:8',
            'destination' => 'nullable|boolean',
            'departure_date' => 'nullable|boolean',
            'return_date' => 'nullable|boolean',
        ];
    }
}
