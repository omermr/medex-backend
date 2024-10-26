<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    const PUBLIC = 1;
    const PRIVATE = 2;
    const ACTIVE = 1;
    const INACTIVE = 2;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'type',
        'cover',
        'status',
        'lat',
        'lng',
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];

    /**
     * Get the user that owns the hospital.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the type of the hospital.
     */
    public function getTypeAttribute($value)
    {
        switch ($value) {
            case self::PUBLIC:
                return 'Public';
            case self::PRIVATE:
                return 'Private';
        }
    }

    /**
     * Get the status of the hospital.
     */
    public function getStatusAttribute($value)
    {
        switch ($value) {
            case self::ACTIVE:
                return 'Active';
            case self::INACTIVE:
                return 'Inactive';
        }
    }

      /**
     * Scope a query to order hospitals by distance from a given point.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  float  $latitude
     * @param  float  $longitude
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByDistance($query, $latitude, $longitude)
    {
        $earthRadius = 6371000;
        return $query->select('hospitals.*')
            ->selectRaw("
                ? * ACOS(
                    COS(RADIANS(?)) *
                    COS(RADIANS(lat)) *
                    COS(RADIANS(lng) - RADIANS(?)) +
                    SIN(RADIANS(?)) *
                    SIN(RADIANS(lat))
                ) AS distance
            ", [$earthRadius, $latitude, $longitude, $latitude])
            ->orderBy('distance');
    }
}
