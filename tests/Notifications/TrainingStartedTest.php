<?php
declare(strict_types=1);

namespace Tests\Notifications;

use App\Models\Brain;
use App\Models\User;
use App\Notifications\TrainingStarted;
use App\View\Components\Notification\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TomHart\SentimentAnalysis\SentimentType;

/**
 * TrainingStartedTest Class Test
 * @package Tests\Notifications
 */
class TrainingStartedTest extends TestCase
{
    use RefreshDatabase;

    private int $brainId;
    private string $sentimentType;
    private string $filePath;
    private TrainingStarted $sut;

    public function test_get_data(): void
    {
        $brain = Brain::findOrFail($this->brainId);

        $expected = new Builder();
        $expected
            ->setIcon('fas fa-hourglass-start')
            ->setColour('orange')
            ->setTitle('Training Started')
            ->setMessage(sprintf(
                'Brain "%s" has started training on %s sentiments from file "%s"',
                $brain->name ?? '',
                $this->sentimentType ?? '',
                $this->filePath ?? ''
            ));

        $actual = TrainingStarted::getData($this->sut->toArray(new User()));
        self::assertEquals($expected, $actual);
    }

    public function test_via(): void
    {
        self::assertEquals(['database'], $this->sut->via(new User()));
    }

    public function test_to_array(): void
    {
        self::assertEquals([
            'brain_id' => $this->brainId,
            'sentiment_type' => $this->sentimentType,
            'file_path' => $this->filePath
        ], $this->sut->toArray(new User()));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $brain = new Brain(['name' => 'Test Brain']);
        $brain->save();
        $this->brainId = $brain->id;
        $this->sentimentType = SentimentType::POSITIVE;
        $this->filePath = 'some/path';
        $this->sut = new TrainingStarted(
            $this->brainId,
            $this->sentimentType,
            $this->filePath
        );
    }
}
