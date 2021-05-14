<?php
declare(strict_types=1);

namespace App\Http\Livewire\Brain;

use App\Http\Livewire\BaseComponent;
use Illuminate\View\View;

/**
 * Class CreatePanel
 * @package App\Http\Livewire\Brain
 */
class CreatePanel extends BaseComponent
{
    /** @var string The brain name to make */
    public string $name = '';

    protected array $rules = [
        'name' => ['required', 'min:8', 'max:255']
    ];

    /**
     * Create a new brain.
     *
     * @return void
     */
    public function create(): void
    {
        $this->resetErrorBag();

        $this->getUserProperty()->brains()->create(
            $this->validate()
        );

        $this->name = '';

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
