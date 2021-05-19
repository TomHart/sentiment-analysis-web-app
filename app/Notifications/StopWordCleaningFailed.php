<?php
declare(strict_types=1);

namespace App\Notifications;

use App\Models\Brain;
use App\Models\User;
use App\View\Components\Notification\Builder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;

/**
 * Class TrainingFailed
 * @package App\Notifications
 */
class StopWordCleaningFailed extends Notification implements RenderableNotification
{
    use Queueable;

    private Throwable $exception;
    private int $brainId;

    /**
     * Create a new notification instance.
     *
     * @param Throwable $exception
     * @param int $brainId
     */
    public function __construct(Throwable $exception, int $brainId)
    {
        $this->exception = $exception;
        $this->brainId = $brainId;
    }

    /**
     * @param array $data
     * @return Builder
     */
    public static function getData(array $data): Builder
    {
        $brain = Brain::find($data['brain_id'] ?? '');

        $builder = new Builder();
        $builder
            ->setIcon('fa fa-cross')
            ->setColour('red')
            ->setTitle('Training Failed')
            ->setMessage(sprintf(
                'Brain "%s" has failing updating their stop words with your list',
                $brain->name ?? ''
            ));

        return $builder;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param User $notifiable
     * @return array
     */
    public function via(User $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param User $notifiable
     * @return array
     */
    #[ArrayShape(['error' => 'string', 'brain_id' => 'int'])]
    public function toArray(User $notifiable): array
    {
        return [
            'error' => $this->exception->getMessage(),
            'brain_id' => $this->brainId
        ];
    }
}
