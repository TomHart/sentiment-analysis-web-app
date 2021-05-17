<?php
declare(strict_types=1);

namespace Tests\View\Components;

use App\Models\Brain;
use App\Notifications\TrainingStarted;
use App\View\Components\Notification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use stdClass;
use Tests\TestCase;

/**
 * NotificationTest Class Test
 * @package Tests\View\Components
 */
class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_render_renderable_notification(): void
    {
        $brain = new Brain(['name' => 'Test Brain']);
        $brain->save();

        $notification = new DatabaseNotification();
        $notification->type = TrainingStarted::class;
        $notification->data = [
            'brain_id' => $brain->id
        ];
        $notification->created_at = Carbon::now();

        $sut = new Notification($notification);
        $view = $sut->render();
        self::assertEquals('components.notifications.pop-up', $view->getName());
    }

    public function test_render_none_renderable_notification(): void
    {
        $brain = new Brain(['name' => 'Test Brain']);
        $brain->save();

        $notification = new DatabaseNotification();
        $notification->type = stdClass::class;

        $sut = new Notification($notification);
        $view = $sut->render();
        self::assertEquals('', $view);
    }
}
