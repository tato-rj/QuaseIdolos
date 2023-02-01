<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NotEmail implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ! str_contains($value, '@');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O nome não pode ser um email.';
    }
}
