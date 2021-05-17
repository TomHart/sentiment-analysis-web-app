<?php
declare(strict_types=1);

namespace Tests\Http\Livewire\Brain;

use App\Http\Livewire\Brain\DeletePanel;
use App\Models\Brain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * DeletePanelTest Class Test
 * @package Tests\Http\Livewire\Brain
 */
class DeletePanelTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Brain $brain;

    public function test_can_confirm_deletion(): void
    {
        /** @var DeletePanel $component */
        $component = Livewire
            ::test(DeletePanel::class, ['brain' => $this->brain])
            ->call('confirmDeletion');

        self::assertTrue($this->user->brains()->where('name', 'New Brain Name')->exists());
        self::assertTrue($component->confirmingDeletion);
    }

    public function test_can_delete_brain(): void
    {
        /** @var DeletePanel $component */
        $component = Livewire
            ::test(DeletePanel::class, ['brain' => $this->brain])
            ->call('delete');

        self::assertFalse($this->user->brains()->where('name', 'New Brain Name')->exists());
        self::assertFalse($component->confirmingDeletion);
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
