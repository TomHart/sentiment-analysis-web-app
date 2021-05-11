<?php
declare(strict_types=1);

namespace App\Notifications;

use App\View\Components\Notification\Builder;

/**
 * Interface RenderableNotification
 * @package App\Notifications
 */
interface RenderableNotification
{
    /**
     * Convert the notification to a builder.
     * @param array $data
     * @return Builder
     */
    public static function getData(array $data): Builder;
}
