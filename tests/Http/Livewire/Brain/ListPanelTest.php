<?php
declare(strict_types=1);

namespace Tests\Http\Livewire\Brain;

use App\Http\Livewire\Brain\ListPanel;
use App\Models\Brain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * ListPanelTest Class Test
 * @package Tests\Http\Livewire\Brain
 */
class ListPanelTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function test_can_get_brains(): void
    {
        /** @var ListPanel $component */
        $component = Livewire::test(ListPanel::class);

        self::assertEquals($this->user->brains, $component->brains);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->actingAs($this->user);
        $this->brain = new Brain(['name' => 'New Brain Name']);
        $this->brain->save();
        $this->brain->users()->save($this->user);
    }
}
