<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Models\Brain;
use App\Models\User;
use App\Notifications\StopWordCleaningFailed;
use App\Notifications\StopWordCleaningFinished;
use App\Notifications\StopWordCleaningStarted;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Class StopWordCleaning
 * @package App\Jobs
 */
class StopWordCleaning implements ShouldQueue
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

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Brain $brain
     */
    public function __construct(User $user, Brain $brain)
    {
        $this->user = $user;
        $this->brain = $brain;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
        $this->user->notify(new StopWordCleaningStarted($this->brain->id));

        $brain = $this->brain->toBrain();
        $stopWords = $brain->getStopWords();

        $words = $this->brain->words()->whereIn('word', $stopWords)->get();

        DB::beginTransaction();
        $words->chunk(1000)->each(function ($words) {
            $this->brain->words()->detach($words->pluck('id'));
            $words->each->delete();
        });
        DB::commit();

        $this->user->notify(new StopWordCleaningFinished($this->brain->id));
    }

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception): void
    {
        $this->user->notify(new StopWordCleaningFailed($exception, $this->brain->id));
    }
}
