<?php
declare(strict_types=1);

namespace App\Http\Livewire\Consumer;

use App\Http\Livewire\BaseComponent;
use Illuminate\View\View;

/**
 * Class NavigationMenu
 * @package App\Http\Livewire\Consumer
 */
class NavigationMenu extends BaseComponent
{
    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.consumer.navigation-menu');
    }
}
