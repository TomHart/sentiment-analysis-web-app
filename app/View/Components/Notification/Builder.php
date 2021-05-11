<?php
declare(strict_types=1);

namespace App\View\Components\Notification;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class Builder
 * @package App\View\Components\Notification
 */
class Builder implements Arrayable
{
    public string $icon;
    public string $colour;
    public string $title;
    public string $message;
    public string $date;

    /**
     * @return string[]
     */
    #[ArrayShape(['icon' => 'string', 'colour' => 'string', 'title' => 'string', 'message' => 'string', 'date' => 'string'])]
    #[Pure]
    public function toArray(): array
    {
        return [
            'icon' => $this->getIcon(),
            'colour' => $this->getColour(),
            'title' => $this->getTitle(),
            'message' => $this->getMessage(),
            'date' => $this->getDate()
        ];
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return Builder
     */
    public function setIcon(string $icon): Builder
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getColour(): string
    {
        return $this->colour;
    }

    /**
     * @param string $colour
     * @return Builder
     */
    public function setColour(string $colour): Builder
    {
        $this->colour = $colour;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Builder
     */
    public function setTitle(string $title): Builder
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Builder
     */
    public function setMessage(string $message): Builder
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string|Carbon $date
     * @return Builder
     */
    public function setDate(string|Carbon $date): Builder
    {
        if ($date instanceof Carbon) {
            $date = $date->diffForHumans();
        }

        $this->date = $date;
        return $this;
    }


}
