<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PrefectureRule implements Rule
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
        dd($value);
        return preg_match('/\A[1-47]\z/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '都道府県を選択して下さい';
    }
}
