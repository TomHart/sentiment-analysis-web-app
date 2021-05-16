<?php
declare(strict_types=1);

namespace Tests\Notifications;

use App\Models\Brain;
use App\Models\User;
use App\Notifications\TrainingFailed;
use App\View\Components\Notification\Builder;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TomHart\SentimentAnalysis\SentimentType;

/**
 * TrainingFailedTest Class Test
 * @package Tests\Notifications
 */
class TrainingFailedTest extends TestCase
{
    use RefreshDatabase;

    private int $brainId;
    private string $sentimentType;
    private string $filePath;
    private TrainingFailed $sut;

    public function test_get_data(): void
    {
        $brain = Brain::findOrFail($this->brainId);

        $expected = new Builder();
        $expected
            ->setIcon('fa fa-cross')
            ->setColour('red')
            ->setTitle('Training Failed')
            ->setMessage(sprintf(
                'Brain "%s" has failed training on %s sentiments from file "%s"',
                $brain->name ?? '',
                $this->sentimentType ?? '',
                $this->filePath ?? ''
            ));

        $actual = TrainingFailed::getData($this->sut->toArray(new User()));
        self::assertEquals($expected, $actual);
    }

    public function test_via(): void
    {
        self::assertEquals(['database'], $this->sut->via(new User()));
    }

    public function test_to_array(): void
    {
        self::assertEquals([
            'error' => 'Some Error',
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
        $exception = new Exception('Some Error');
        $this->brainId = $brain->id;
        $this->sentimentType = SentimentType::POSITIVE;
        $this->filePath = 'some/path';
        $this->sut = new TrainingFailed(
            $exception,
            $this->brainId,
            $this->sentimentType,
            $this->filePath
        );
    }
}
