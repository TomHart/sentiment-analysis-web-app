<?php
declare(strict_types=1);

namespace App\Http\Livewire\Brain;

use App\Http\Livewire\BaseComponent;
use App\Models\Brain;
use App\SentimentAnalysis\DatabaseBrain;
use App\SentimentAnalysis\Memories\DatabaseLoader;
use Illuminate\View\View;
use TomHart\SentimentAnalysis\Analyser\Analyser;
use TomHart\SentimentAnalysis\Analyser\AnalysisResult;

/**
 * Class UsePanel
 * @package App\Http\Livewire\Brain
 */
class UsePanel extends BaseComponent
{
    public Brain $brain;

    /** @var string The sentence to test. */
    public string $sentence = 'good example of a great sentence';
    /** @var null|AnalysisResult */
    private ?AnalysisResult $result = null;

    /**
     * @return null|AnalysisResult
     */
    public function getResultProperty(): ?AnalysisResult
    {
        return $this->result;
    }

    public function clearResult(): void
    {
        $this->result = null;
    }

    public function useBrain(): void
    {
        $loader = new DatabaseLoader($this->brain);
        $brain = new DatabaseBrain($this->brain, $loader);
        $analyser = new Analyser();
        $analyser->setBrain($brain);

        $this->result = $analyser->analyse($this->sentence);
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.brain.use-panel');
    }
}
