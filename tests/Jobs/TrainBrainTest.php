<?php
declare(strict_types=1);

namespace Tests\Jobs;

use App\Jobs\TrainBrain;
use App\Models\Brain;
use App\Models\User;
use App\Notifications\TrainingFailed;
use App\Notifications\TrainingFinished;
use App\Notifications\TrainingStarted;
use App\SentimentAnalysis\DatabaseBrain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use Throwable;
use TomHart\SentimentAnalysis\SentimentType;

/**
 * TrainBrainTest Class Test
 * @package Tests\Jobs
 */
class TrainBrainTest extends TestCase
{
    use RefreshDatabase;

    private MockObject|User $user;
    private Brain|MockObject $brain;
    private TrainBrain $sut;

    /**
     * @throws Throwable
     */
    public function test_user_notified(): void
    {
        $this->user
            ->expects(self::exactly(2))
            ->method('notify')
            ->withConsecutive(
                [new TrainingStarted($this->brain->id, SentimentType::POSITIVE, 'some/path')],
                [new TrainingFinished($this->brain->id, SentimentType::POSITIVE, 'some/path')]
            );

        $brain = $this->createMock(DatabaseBrain::class);
        $brain
            ->expects(self::once())
            ->method('setBrain')
            ->with($this->brain);

        $brain
            ->expects(self::once())
            ->method('insertTrainingData')
            ->with('some/path', SentimentType::POSITIVE, 1000);

        $this->sut->handle($brain);
    }

    /**
     * @throws Throwable
     */
    public function test_user_notified_on_failure(): void
    {
        $throwable = $this->createMock(Throwable::class);

        $this->user
            ->expects(self::once())
            ->method('notify')
            ->with(
                new TrainingFailed($throwable, $this->brain->id, SentimentType::POSITIVE, 'some/path')
            );

        $this->sut->failed($throwable);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createMock(User::class);
        $this->brain = new Brain();
        $this->brain->name = 'Test Brain';
        $this->brain->save();

        $this->sut = new TrainBrain($this->user, $this->brain, SentimentType::POSITIVE, 'some/path');
    }
}
