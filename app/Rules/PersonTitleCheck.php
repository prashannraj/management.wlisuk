<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PersonTitleCheck implements Rule
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
        if (in_array($value, getTitle())) {
            return $value;
        }
    }

    public function setAttributeNames(array $attributes)
    {
        $this->attributes = ucfirst($attributes);
        return $this;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute not found';
    }
}
