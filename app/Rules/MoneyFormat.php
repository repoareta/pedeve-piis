<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MoneyFormat implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $regex = '/^\-?\d+(,\d{3})*(\.\d+)?$/';

        $value = (string) sanitize_nominal($value);

        $validate = preg_match($regex, $value);

        if ($validate == 1) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format :attribute tidak valid.';
    }
}
