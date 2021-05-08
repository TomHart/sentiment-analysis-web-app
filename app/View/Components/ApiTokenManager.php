<?php
declare(strict_types=1);

namespace App\View\Components;

use App\Models\PersonalAccessToken;
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
     * The create API token form state.
     *
     * @var array
     */
    public $createApiTokenForm = [
        'name' => '',
        'brain_id' => '',
        'permissions' => [],
    ];

    /**
     * The update API token form state.
     *
     * @var array
     */
    public $updateApiTokenForm = [
        'brain_id' => '',
        'permissions' => [],
    ];

    /** @var PersonalAccessToken|null */
    public ?PersonalAccessToken $tokenBeingUpdated;

    /**
     * @throws ValidationException
     */
    public function createApiToken(): void
    {
        $this->resetErrorBag();

        Validator::make([
            'name' => $this->createApiTokenForm['name'],
            'brain_id' => $this->createApiTokenForm['brain_id']
        ], [
            'name' => ['required', 'string', 'max:255'],
            'brain_id' => ['required', 'int', 'exists:brains,id'],
        ])->validateWithBag('createApiToken');

        $this->displayTokenValue($this->getUserProperty()->createToken(
            $this->createApiTokenForm['name'],
            (int)$this->createApiTokenForm['brain_id'],
            Jetstream::validPermissions($this->createApiTokenForm['permissions'])
        ));

        $this->createApiTokenForm['name'] = '';
        $this->createApiTokenForm['permissions'] = Jetstream::$defaultPermissions;

        $this->emit('created');
    }

    /**
     * Update the API token's permissions.
     *
     * @return void
     */
    public function updateApiToken(): void
    {
        $this->managingPermissionsFor->forceFill([
            'abilities' => Jetstream::validPermissions($this->updateApiTokenForm['permissions']),
            'brain_id' => $this->updateApiTokenForm['brain_id'],
        ])->save();

        $this->managingApiTokenPermissions = false;
    }

    /**
     * @param PersonalAccessToken $token
     */
    public function manageTokenPermissions(PersonalAccessToken $token): void
    {
        $this->updateApiTokenForm['brain_id'] = $token->brain->id;
        $this->manageApiTokenPermissions($token->id);
    }
}
