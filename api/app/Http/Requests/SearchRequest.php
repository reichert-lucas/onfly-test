<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => 'nullable|string|min:1',
            'barcode' => 'integer|exists:menu_items,code',
        ];
    }
}
