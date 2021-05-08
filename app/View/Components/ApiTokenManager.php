<?php
declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager as BaseApiTokenManager;
use Laravel\Jetstream\Jetstream;

/**
 * Class ApiTokenManager
 * @package App\View\Components
 */
class ApiTokenManager extends BaseApiTokenManager
{
    /**
     * @throws ValidationException
     */
    public function createApiToken(): void
    {
        $this->resetErrorBag();

        Validator::make([
            'name' => $this->createApiTokenForm['name'],
            'brain' => $this->createApiTokenForm['brain']
        ], [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createApiToken');

        $this->displayTokenValue($this->getUserProperty()->createToken(
            $this->createApiTokenForm['name'],
            $this->createApiTokenForm['brain'],
            Jetstream::validPermissions($this->createApiTokenForm['permissions'])
        ));

        $this->createApiTokenForm['name'] = '';
        $this->createApiTokenForm['permissions'] = Jetstream::$defaultPermissions;

        $this->emit('created');
    }
}
