<?php
declare(strict_types=1);

namespace Tests\Http\Livewire\Brain;

use App\Http\Livewire\Brain\TrainingPanel;
use App\Jobs\TrainBrain;
use App\Models\Brain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * TrainingPanelTest Class Test
 * @package Tests\Http\Livewire\Brain
 */
class TrainingPanelTest extends TestCase
{
    use RefreshDatabase;

    private Brain $brain;

    public function test_can_schedule_job(): void
    {
        $textFile = UploadedFile::fake()->create('me.txt');
        Queue::fake();

        Livewire::test(TrainingPanel::class, ['brain' => $this->brain])
            ->set('file', $textFile)
            ->call('train')
            ->assertEmitted('scheduled');

        Queue::assertPushed(TrainBrain::class);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $user = $this->createUser();
        $this->actingAs($user);
        $this->brain = new Brain(['name' => 'New Brain Name']);
        $this->brain->save();
        $this->brain->users()->save($user);
    }
}
