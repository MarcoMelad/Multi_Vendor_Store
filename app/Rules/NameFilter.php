<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NameFilter implements Rule
{
    protected $forbidden;
    public function __construct($forbidden)
    {
        return $this->forbidden = $forbidden;
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
        if (in_array(strtolower($value), $this->forbidden)){
            return false;
        }
        return true;
//        return ! in_array(strtolower($value), $this->forbidden);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This Value Is Not Allowed.';
    }
}
