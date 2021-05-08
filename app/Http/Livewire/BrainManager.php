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
     * The create brain form state.
     *
     * @var array
     */
    public array $createBrainForm = [
        'name' => '',
    ];

    /** @var bool */
    public bool $confirmingBrainDeletion = false;
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

    /** @var ?int */
    public ?int $brainIdBeingDeleted = null;

    /**
     * Create a new brain.
     *
     * @return void
     * @throws ValidationException
     */
    public function createBrain(): void
    {
        $this->resetErrorBag();

        Validator::make([
            'name' => $this->createBrainForm['name'],
        ], [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag(__METHOD__);

        $brain = new Brain();
        $brain->name = $this->createBrainForm['name'];
        $brain->save();
        $brain->users()->save($this->getUserProperty());

        $this->createBrainForm['name'] = '';

        $this->emit('created');
    }

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
     * Confirm that the given brain should be deleted.
     *
     * @param int $brainId
     * @return void
     */
    public function confirmBrainDeletion(int $brainId): void
    {
        $this->confirmingBrainDeletion = true;
        $this->brainIdBeingDeleted = $brainId;
    }

    /**
     * Delete the brain.
     *
     * @return void
     */
    public function deleteBrain(): void
    {
        $brain = $this->getUserProperty()
            ->brains()
            ->where('brains.id', $this
                ->brainIdBeingDeleted)
            ->firstOrFail();

        if ($brain) {
            $this->getUserProperty()->brains()->detach($brain);
            $brain->delete();
        }

        $this->getUserProperty()->load('brains');

        $this->brainIdBeingDeleted = null;
        $this->confirmingBrainDeletion = false;
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('brains.brain-manager');
    }
}
