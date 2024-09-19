<?php

namespace App\Rules;

use App\Models\School;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SchoolValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!School::where('id', $value)->exists()) {
            $fail('The selected school is invalid.');
        }
    }
}
