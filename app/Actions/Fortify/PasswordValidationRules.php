<?php
declare(strict_types=1);

namespace App\Actions\Fortify;

use JetBrains\PhpStorm\Pure;
use Laravel\Fortify\Rules\Password;

/**
 * Trait PasswordValidationRules
 * @package App\Actions\Fortify
 */
trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    #[Pure]
    protected function passwordRules(): array
    {
        return ['required', 'string', new Password(), 'confirmed'];
    }
}
