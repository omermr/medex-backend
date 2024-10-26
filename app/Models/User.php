<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // User Status
    const ACTIVE    = 1;
    const INACTIVE  = 2;
    const PENDING   = 3;

    // User Role
    const ADMIN     = 1;
    const DOCTOR    = 2;
    const PATIENT   = 3;
    const HOSPITAL  = 4;

    // User Gender
    const MALE      = 1;
    const FEMALE    = 2;

    // User Provider
    const GOOGLE    = 1;
    const FACEBOOK  = 2;

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'role',
        'status',
        'avatar',
        'provider',
        'provider_id',
        'is_admin',
        'gender',
        'date_of_birth',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    /**
     * Get the user's status as a string.
     *
     * @param  mixed  $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        switch ($value) {
            case self::ACTIVE:
                return 'active';
            case self::INACTIVE:
                return 'inactive';
            case self::PENDING:
                return 'pending';
            default:
                return 'unknown';
        }
    }

    public function getRoleAttribute($value)
    {
        switch ($value) {
            case self::ADMIN:
                return 'admin';
            case self::DOCTOR:
                return 'doctor';
            case self::PATIENT:
                return 'patient';
            case self::HOSPITAL:
                return 'hospital';
            default:
                return 'unknown';
        }
    }

    public function getGenderAttribute($value)
    {
        switch ($value) {
            case self::MALE:
                return 'male';
            case self::FEMALE:
                return 'female';
        }
    }
}
