<?php
declare(strict_types=1);

namespace App\Notifications;

use App\Models\Brain;
use App\Models\User;
use App\View\Components\Notification\Builder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class TrainingFinished
 * @package App\Notifications
 */
class StopWordCleaningFinished extends Notification implements RenderableNotification
{
    use Queueable;

    private int $brainId;

    /**
     * Create a new notification instance.
     *
     * @param int $brainId
     */
    public function __construct(int $brainId)
    {
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
            ->setIcon('fas fa-check')
            ->setColour('green')
            ->setTitle('Stop Word Update Finished')
            ->setMessage(sprintf(
                'Brain "%s" has finished updating their stop words with your list',
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
    #[ArrayShape(['brain_id' => 'int'])]
    public function toArray(User $notifiable): array
    {
        return [
            'brain_id' => $this->brainId
        ];
    }
}
