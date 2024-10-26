<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{
    use HasFactory;

    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $fillable = ['user_id', 'speciality_id', 'status', 'bio', 'experience', 'description', 'cover'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::INACTIVE);
    }

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case self::ACTIVE:
                return 'Active';
            case self::INACTIVE:
                return 'Inactive';
            default:
                return 'Unknown';
        }
    }
}
