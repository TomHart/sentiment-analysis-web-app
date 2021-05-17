<?php
declare(strict_types=1);

namespace App\View\Components;

use App\Notifications\RenderableNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification as LaravelNotification;
use Illuminate\View\Component;

/**
 * Class Notification
 * @package App\View\Components
 */
class Notification extends Component
{
    public LaravelNotification $notification;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(LaravelNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        $class = $this->notification->type;

        if (is_subclass_of($class, RenderableNotification::class)) {
            $data = $class::getData($this->notification->data);
            $data->setDate($this->notification->{Model::CREATED_AT});

            return view('components.notifications.pop-up', $data);
        }

        return '';
    }
}
