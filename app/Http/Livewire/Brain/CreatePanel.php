<?php
declare(strict_types=1);

namespace App\Http\Livewire\Brain;

use App\Http\Livewire\BaseComponent;
use App\Models\Brain;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Class CreatePanel
 * @package App\Http\Livewire\Brain
 */
class CreatePanel extends BaseComponent
{
    /**
     * The create brain form state.
     *
     * @var array
     */
    public array $createBrainForm = [
        'name' => '',
    ];

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
     * @return View
     */
    public function render(): View
    {
        return view('livewire.brain.create-panel');
    }
}
