<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Models\Brain;
use App\Models\User;
use App\Notifications\TrainingFailed;
use App\Notifications\TrainingFinished;
use App\Notifications\TrainingStarted;
use App\SentimentAnalysis\DatabaseBrain;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;
use TomHart\SentimentAnalysis\Brain\BrainInterface;

/**
 * Class TrainBrain
 * @package App\Jobs
 */
class TrainBrain implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public int $timeout = 1200;

    private User $user;
    private Brain $brain;
    private string $sentimentType;
    private string $filePath;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Brain $brain
     * @param string $sentimentType
     * @param string $filePath
     */
    public function __construct(User $user, Brain $brain, string $sentimentType, string $filePath)
    {
        $this->user = $user;
        $this->brain = $brain;
        $this->sentimentType = $sentimentType;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @param BrainInterface $brain
     * @return void
     * @throws Throwable
     */
    public function handle(BrainInterface $brain): void
    {
        $this->user->notify(new TrainingStarted($this->brain->id, $this->sentimentType, $this->filePath));

        DB::beginTransaction();
        /** @var $brain DatabaseBrain */
        $brain->setBrain($this->brain);
        $brain->insertTrainingData($this->filePath, $this->sentimentType, 1000);
        DB::commit();

        $this->user->notify(new TrainingFinished($this->brain->id, $this->sentimentType, $this->filePath));
    }

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception): void
    {
        $this->user->notify(new TrainingFailed($exception, $this->brain->id, $this->sentimentType, $this->filePath));
    }
}
