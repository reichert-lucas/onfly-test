<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\RequiredIf;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|min:1|max:255',
            'email' => "nullable|email|max:255|unique:users,id,{$this->user->id}",
            'password' => 'nullable|min:8',
            'is_admin' => 'nullable|boolean',
            'system_id' => [
                new RequiredIf(!Auth::user()->system_id),
                'exists:systems,id'
            ]
        ];
    }
}
