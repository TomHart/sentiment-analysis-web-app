<?php
declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Brain;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Laravel\Sanctum\PersonalAccessToken;
use Livewire\Component;

/**
 * Class BrainManager
 * @package Laravel\Jetstream\Http\Livewire
 */
class BrainManager extends Component
{
    /**
     * Indicates if the plain text token is being displayed to the user.
     *
     * @var bool
     */
    public $displayingToken = false;
    /**
     * Indicates if the user is currently managing an API token's permissions.
     *
     * @var bool
     */
    public $managingApiTokenPermissions = false;
    /**
     * The token that is currently having its permissions managed.
     *
     * @var PersonalAccessToken|null
     */
    public $managingPermissionsFor;
    /**
     * The update API token form state.
     *
     * @var array
     */
    public $updateApiTokenForm = [
        'permissions' => [],
    ];

    /**
     * Get the current user of the application.
     *
     * @return User
     */
    public function getUserProperty(): User
    {
        return Auth::user();
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.brain.brain-manager');
    }
}
