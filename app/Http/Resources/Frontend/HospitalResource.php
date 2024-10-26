<?php

namespace App\Http\Resources\Frontend;

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
            'id'          => $this->id,
            'name'      => $this->user->name,
            'type'      => $this->type,
            'cover'     => $this->cover,
            'distance' => $this->when($this->distance, function () {
                return $this->formatDistance($this->distance);
            }),
            'estimated_time' => $this->when($this->distance, function () {
                return $this->formatTime($this->distance);
            }),
            'status'    => $this->status
        ];
    }

     /**
     * Format the distance in kilometers.
     *
     * @param float $distanceInKm
     * @return string
     */
    private function formatDistance($distanceInKm): string
    {
        return number_format($distanceInKm, 2) . ' km';
    }

    /**
     * Format the estimated time based on distance.
     *
     * @param float $distanceInKm
     * @return string
     */
    private function formatTime($distanceInKm): string
    {
        // Assume average speed of 50 km/h
        $timeInHours = $distanceInKm / 50;
        $hours = floor($timeInHours);
        $minutes = round(($timeInHours - $hours) * 60);

        if ($hours > 0) {
            return "{$hours} h {$minutes} min";
        } else {
            return "{$minutes} min";
        }
    }
}
