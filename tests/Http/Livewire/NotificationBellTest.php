<?php
declare(strict_types=1);

namespace Tests\Http\Livewire;

use App\Http\Livewire\NotificationBell;
use App\Notifications\TrainingFailed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Notification;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * NotificationBellTest Class Test
 * @package Tests\Http\Livewire
 */
class NotificationBellTest extends TestCase
{
    use RefreshDatabase;

    public function test_rendering_bell(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $component = Livewire
            ::test(NotificationBell::class);

        $component->assertSeeHtml('svg');
        $component->assertDontSeeHtml('animate-swing');
    }

    public function test_bell_swings_with_notifications(): void
    {
        $notification = $this->createMock(TrainingFailed::class);

        $notification
            ->expects(self::once())
            ->method('via')
            ->willReturn(['database']);

        $user = $this->createUser();
        $this->actingAs($user);
        $user->notify($notification);

        $component = Livewire::test(NotificationBell::class);

        $component->assertSeeHtml('svg');
        $component->assertSeeHtml('animate-swing');
    }
}
