<?php
declare(strict_types=1);

namespace App\Http\Livewire;

use Illuminate\View\View;

/**
 * Class NotificationBell
 * @package App\Http\Livewire
 */
class NotificationBell extends BaseComponent
{
    public function render(): View
    {
        return view('livewire.notification-bell', [
            'notifications' => $this->getUserProperty()->notifications,
            'unreadNotifications' => $this->getUserProperty()->unreadNotifications
        ]);
    }
}
