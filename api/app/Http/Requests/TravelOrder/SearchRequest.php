<?php

namespace App\Http\Requests\TravelOrder;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status_id' => 'nullable|integer|exists:travel_order_statuses,id',
            'search' => 'nullable|string',
            'departure_date' => 'nullable|date',
            'return_date' => 'nullable|date',
        ];
    }
}
