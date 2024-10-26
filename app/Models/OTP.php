<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    const EMAIL_VERIFICATION    = 1;
    const PASSWORD_RESET        = 2;
    const PHONE_VERIFICATION    = 3;

    protected $fillable = ['user_id', 'otp', 'type', 'expires_at', 'is_used'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isValid()
    {
        return !$this->is_used && $this->expires_at->isFuture();
    }

    public function getTypeNameAttribute($value) {
        switch ($this->type) {
            case self::EMAIL_VERIFICATION:
                return 'Email Verification';
            case self::PASSWORD_RESET:
                return 'Password Reset';
            case self::PHONE_VERIFICATION:
                return 'Phone Verification';
            default:
                return 'Unknown';
        }
    }
}
