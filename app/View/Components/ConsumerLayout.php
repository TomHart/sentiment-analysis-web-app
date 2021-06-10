<?php
declare(strict_types=1);

namespace App\View\Components;

use App\Models\Brain;
use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Class ConsumerLayout
 * @package App\View\Components
 */
class ConsumerLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('layouts.consumer');
    }
}
