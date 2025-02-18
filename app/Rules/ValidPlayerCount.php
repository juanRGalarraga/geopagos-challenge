<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPlayerCount implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //If playersCount is a power of 2 the bitwise operation will return 0
        $countOf = count($value);
        $isPowerOf2 = ($countOf & ($countOf - 1)) === 0 && $countOf > 0;
        if(!$isPowerOf2){
            $fail("The number of players must be a power of 2");
        }
    }
}
