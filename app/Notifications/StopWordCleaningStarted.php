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
 * Class TrainingStarted
 * @package App\Notifications
 */
class StopWordCleaningStarted extends Notification implements RenderableNotification
{
    use Queueable;

    private int $brainId;

    /**
     * Create a new notification instance.
     *
     * @param int $brainId
     * @return void
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
            ->setIcon('fas fa-hourglass-start')
            ->setColour('orange')
            ->setTitle('Stop Word Update Started')
            ->setMessage(sprintf(
                'Brain "%s" has started updating their stop words with your list',
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
