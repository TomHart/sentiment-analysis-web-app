<?php
declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

/**
 * Class NotificationsController
 * @package App\Http\Controllers\Dashboard
 */
class NotificationsController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = auth()->user();
        $notifications = $user->notifications()->orderBy('created_at', 'DESC')->limit(50)->get();

        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }

        return view('dashboard.notifications', [
            'notifications' => $notifications
        ]);
    }
}
