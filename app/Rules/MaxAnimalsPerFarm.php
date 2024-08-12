<?php

namespace App\Rules;

use App\Models\Animal;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxAnimalsPerFarm implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    private int $farmId;
    public function __construct(int $farmId)
    {
        $this->farmId = $farmId;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Animal::where('farm_id', $this->farmId)->count() >= 3) {
            $fail('Maximum number of animals per farm is 3');
        }
    }
}
