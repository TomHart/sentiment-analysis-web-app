<?php
declare(strict_types=1);

namespace App\Http\Livewire\Brain;

use App\Http\Livewire\BaseComponent;
use App\Models\Brain;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\View\View;
use TomHart\SentimentAnalysis\Analyser\AnalyserInterface;
use TomHart\SentimentAnalysis\Analyser\AnalysisResult;

/**
 * Class UsePanel
 * @package App\Http\Livewire\Brain
 * @property null|AnalysisResult result
 */
class UsePanel extends BaseComponent
{
    public Brain $brain;
    public string $sentence = 'good example of a great sentence';
    private ?AnalysisResult $result = null;

    /**
     * @return null|AnalysisResult
     */
    public function getResultProperty(): ?AnalysisResult
    {
        return $this->result;
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function useBrain(): void
    {
        $analyser = app()->make(AnalyserInterface::class, [
            'brain' => $this->brain
        ]);

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
