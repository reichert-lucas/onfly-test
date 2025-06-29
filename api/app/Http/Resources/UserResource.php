<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'system' => new SystemResource($this->system),
            'is_admin' => $this->is_admin,
            'is_super_admin' => $this->is_super_admin,
        ];
    }
}
