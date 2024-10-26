<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->user->name,
            'type' => $this->type,
            'cover' => $this->cover,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'status' => $this->status
        ];
    }
}
