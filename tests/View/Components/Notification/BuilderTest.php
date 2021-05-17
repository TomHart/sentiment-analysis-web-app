<?php
declare(strict_types=1);

namespace Tests\View\Components\Notification;

use App\View\Components\Notification\Builder;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * BuilderTest Class Test
 * @package Tests\View\Components\Notification
 */
class BuilderTest extends TestCase
{
    public function test_is_arrayable(): void
    {
        self::assertInstanceOf(Arrayable::class, new Builder());
    }

    public function test_to_array(): void
    {
        $date = date(DATE_ATOM);
        $builder = new Builder();
        $builder
            ->setIcon('fas fa-check')
            ->setColour('green')
            ->setTitle('Training Finished')
            ->setMessage('Message')
            ->setDate($date);

        self::assertEquals([
            'icon' => 'fas fa-check',
            'colour' => 'green',
            'title' => 'Training Finished',
            'message' => 'Message',
            'date' => $date,
        ], $builder->toArray());
    }

    public function test_carbon_diffs_for_humans(): void
    {
        $date = new Carbon(strtotime('-12 months'));
        $builder = new Builder();
        $builder->setDate($date);

        self::assertEquals('1 year ago', $builder->getDate());
    }
}
