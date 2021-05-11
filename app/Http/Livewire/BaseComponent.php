<?php
declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Class BaseComponent
 * @package App\Http\Livewire
 */
class BaseComponent extends Component
{
    /**
     * Get the current user of the application.
     *
     * @return User
     */
    public function getUserProperty(): User
    {
        return Auth::user();
    }
}
