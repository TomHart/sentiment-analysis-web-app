<?php
declare(strict_types=1);

namespace Tests\Http\Livewire\Brain;

use App\Http\Livewire\Brain\UsePanel;
use App\Models\AnalysisResult as AnalysisResultModel;
use App\Models\Brain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use TomHart\SentimentAnalysis\Analyser\AnalyserInterface;
use TomHart\SentimentAnalysis\Analyser\AnalysisResult;
use TomHart\SentimentAnalysis\SentimentType;

/**
 * UsePanelTest Class Test
 * @package Tests\Http\Livewire\Brain
 */
class UsePanelTest extends TestCase
{
    use RefreshDatabase;

    private Brain $brain;

    public function test_can_use_analyser(): void
    {
        $analyser = $this->createMock(AnalyserInterface::class);

        $result = new AnalysisResult();
        $result->setResult(SentimentType::POSITIVE)
            ->setPositiveAccuracy(0.5)
            ->setNegativeAccuracy(0.5);

        $analyser
            ->expects(self::once())
            ->method('analyse')
            ->with('test sentence')
            ->willReturn($result);

        $this->app->bind(AnalyserInterface::class, fn() => $analyser);

        /** @var UsePanel $component */
        $component = Livewire
            ::test(UsePanel::class, ['brain' => $this->brain])
            ->set('sentence', 'test sentence')
            ->call('useBrain');

        self::assertSame($result, $component->result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->actingAs($this->user);
        $this->brain = new Brain(['name' => 'New Brain Name']);
        $this->brain->save();
        $this->brain->users()->save($this->user);
        $result = new AnalysisResultModel();
        $result->sentence = 'Test Sentence';
        $result->result = SentimentType::POSITIVE;
        $result->positive_accuracy = 0.5;
        $result->negative_accuracy = 0.5;
        $result->brain()->associate($this->brain);
        $result->save();
    }
}
