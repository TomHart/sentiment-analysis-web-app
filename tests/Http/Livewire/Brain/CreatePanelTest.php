<?php
declare(strict_types=1);

namespace Tests\Http\Livewire\Brain;

use App\Http\Livewire\Brain\CreatePanel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * CreatePanelTest Class Test
 * @package Tests\Http\Livewire\Brain
 */
class CreatePanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_post(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        Livewire::test(CreatePanel::class)
            ->set('name', 'New Brain Name')
            ->call('create');

        self::assertTrue($user->brains()->where('name', 'New Brain Name')->exists());
    }

    public function test_can_set_initial_title(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreatePanel::class, ['name' => 'Default Brain Name'])
            ->assertSet('name', 'Default Brain Name');
    }

    public function test_title_rules(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreatePanel::class)
            ->set('name', '')
            ->call('create')
            ->assertHasErrors(['name' => 'required']);

        Livewire::test(CreatePanel::class)
            ->set('name', 'a')
            ->call('create')
            ->assertHasErrors(['name' => 'min']);

        Livewire::test(CreatePanel::class)
            ->set('name', str_repeat('a', 256))
            ->call('create')
            ->assertHasErrors(['name' => 'max']);
    }

    public function test_event_is_emitted_on_success(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreatePanel::class)
            ->set('name', 'New Test Brain')
            ->call('create')
            ->assertEmitted('created');
    }
}
