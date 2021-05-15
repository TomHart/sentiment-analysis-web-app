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
    public bool $confirmingDeletion = false;

    /**
     * Confirm that the given brain should be deleted.
     *
     * @return void
     */
    public function confirmDeletion(): void
    {
        $this->confirmingDeletion = true;
    }

    /**
     * Delete the brain.
     *
     * @returns void
     */
    public function delete(): void
    {
        $user = $this->getUserProperty();
        $brain = $user
            ->brains()
            ->where('brains.id', $this->brain->id)
            ->firstOrFail();

        if ($brain) {
            $user->brains()->detach($brain);
            $brain->delete();
        }

        $user->load('brains');

        $this->confirmingDeletion = false;
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
