<?php
declare(strict_types=1);

namespace App\Notifications;

use App\Models\Brain;
use App\Models\User;
use App\View\Components\Notification\Builder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class TrainingFinished
 * @package App\Notifications
 */
class TrainingFinished extends Notification implements RenderableNotification
{
    use Queueable;

    private int $brainId;
    private string $sentimentType;
    private string $filePath;

    /**
     * Create a new notification instance.
     *
     * @param int $brainId
     * @param string $sentimentType
     * @param string $filePath
     */
    public function __construct(int $brainId, string $sentimentType, string $filePath)
    {
        $this->sentimentType = $sentimentType;
        $this->filePath = $filePath;
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
            ->setTitle('Training Finished')
            ->setMessage(sprintf(
                'Brain "%s" has finished training on %s sentiments from file "%s"',
                $brain->name ?? '',
                $data['sentiment_type'] ?? '',
                $data['file_path'] ?? ''
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
    #[ArrayShape(['brain_id' => 'int', 'sentiment_type' => 'string', 'file_path' => 'string'])]
    public function toArray(User $notifiable): array
    {
        return [
            'brain_id' => $this->brainId,
            'sentiment_type' => $this->sentimentType,
            'file_path' => $this->filePath
        ];
    }
}
