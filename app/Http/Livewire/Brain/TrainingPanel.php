<?php
declare(strict_types=1);

namespace App\Http\Livewire\Brain;

use App\Http\Livewire\BaseComponent;
use App\Jobs\TrainBrain;
use App\Models\Brain;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Throwable;
use TomHart\SentimentAnalysis\Analyser\Analyser;
use TomHart\SentimentAnalysis\SentimentType;

/**
 * Class BrainTrainingForm
 * @package App\Http\Livewire
 */
class TrainingPanel extends BaseComponent
{
    use WithFileUploads;

    public Brain $brain;
    public string $sentimentType = SentimentType::POSITIVE;
    /** @var string|TemporaryUploadedFile|null */
    public string|null|TemporaryUploadedFile $file = null;

    /**
     * @throws Throwable
     */
    public function trainBrain(): void
    {
        $this->validate();

        TrainBrain::dispatch($this->getUserProperty()->id, $this->brain, $this->sentimentType, $this->file->getRealPath());

        $this->sentimentType = SentimentType::POSITIVE;
        $this->file = null;

        $this->emit('scheduled');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.brain.training-panel');
    }

    /**
     * @return array
     */
    #[ArrayShape(['sentimentType' => 'array', 'file' => 'string[]'])]
    protected function rules(): array
    {
        return [
            'sentimentType' => ['required', Rule::in(Analyser::VALID_TYPES)],
            'file' => ['required', 'file']
        ];
    }
}
