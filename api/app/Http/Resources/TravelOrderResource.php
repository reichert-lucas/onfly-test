<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'applicant' => new SimpleUserResource($this->user),
            'status' => new TravelOrderStatusResource($this->status),
            'destination' => $this->destination,
            'departure_date' => $this->departure_date->format('d/m/Y'),
            'return_date' => $this->return_date->format('d/m/Y'),
        ];
    }
}
