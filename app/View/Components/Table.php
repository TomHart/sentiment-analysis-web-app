<?php
declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

/**
 * Class Table
 * @package App\View\Components
 */
class Table extends Component
{
    /**
     * @var array
     */
    public $columns;
    /**
     * @var array
     */
    public $items;

    /**
     * Create a new component instance.
     *
     * @param array $columns
     * @param array|Collection $items
     */
    public function __construct(array $columns, array|Collection $items)
    {
        $this->columns = $columns;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.table');
    }
}
