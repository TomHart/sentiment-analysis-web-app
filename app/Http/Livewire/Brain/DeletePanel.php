<?php
declare(strict_types=1);

namespace App\Http\Livewire\Brain;

use App\Http\Livewire\BaseComponent;
use App\Models\Brain;
use Illuminate\View\View;

/**
 * Class DeletePanel
 * @package App\Http\Livewire\Brain
 */
class DeletePanel extends BaseComponent
{
    public Brain $brain;
    /** @var bool */
    public bool $confirmingBrainDeletion = false;
    /** @var int|null */
    public ?int $brainIdBeingDeleted = null;

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
     * @returns void
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
        $this->redirectRoute('brains.index');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.brain.delete-panel');
    }
}
