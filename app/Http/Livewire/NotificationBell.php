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
    protected $listeners = ['update' => '$refresh'];

    public function render(): View
    {
        $user = $this->getUserProperty();
        return view('livewire.notification-bell', [
            'notifications' => $user->notifications,
            'unreadNotifications' => $user->unreadNotifications
        ]);
    }
}
