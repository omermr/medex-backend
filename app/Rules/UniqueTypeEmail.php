<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class UniqueTypeEmail implements Rule
{
    protected $userId;
    protected $type;

    public function __construct($userId = null, $type)
    {
        $this->userId = $userId;
        $this->type = $type;
    }

    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        return !User::where('email', $value)
            ->where('role', $this->type)
            ->when($this->userId, function ($query) {
                $query->where('id', '!=', $this->userId);
            })
            ->exists();
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The email is already taken by another user with this type.';
    }
}
