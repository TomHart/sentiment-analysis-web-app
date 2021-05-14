<?php
declare(strict_types=1);

namespace App\Http\Livewire\Brain;

use App\Http\Livewire\BaseComponent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

/**
 * Class ListPanel
 * @package App\Http\Livewire\Brain
 */
class ListPanel extends BaseComponent
{
    /**
     * @return Collection
     */
    public function getBrainsProperty(): Collection
    {
        return $this->getUserProperty()->brains;
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.brain.list-panel');
    }
}
