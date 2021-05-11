<?php
declare(strict_types=1);

namespace App\Http\Livewire;

use App\Jobs\TrainBrain;
use App\Models\Brain;
use App\Models\User;
use App\Rules\HasAccessTo;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Throwable;
use TomHart\SentimentAnalysis\Analyser\Analyser;
use TomHart\SentimentAnalysis\SentimentType;

/**
 * Class BrainTrainingForm
 * @package App\Http\Livewire
 */
class BrainTrainingForm extends Component
{
    use WithFileUploads;

    public ?int $brainId = null;
    public string $sentimentType = SentimentType::POSITIVE;
    /** @var string|TemporaryUploadedFile|null */
    public string|null|TemporaryUploadedFile $file = null;

    /**
     * @throws Throwable
     */
    public function trainBrain(): void
    {
        $this->validate();

        $brain = Brain::find($this->brainId);
        TrainBrain::dispatch($this->getUserProperty()->id, $brain, $this->sentimentType, $this->file->getRealPath());

        $this->brainId = null;
        $this->sentimentType = SentimentType::POSITIVE;
        $this->file = null;

        $this->emit('scheduled');
    }

    /**
     * Get the current user of the application.
     *
     * @return User
     */
    public function getUserProperty(): User
    {
        return Auth::user();
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.brain.brain-training-form');
    }

    /**
     * @return array
     */
    #[ArrayShape(['brainId' => 'array', 'sentimentType' => 'array', 'file' => 'string[]'])]
    protected function rules(): array
    {
        return [
            'brainId' => ['required', new HasAccessTo($this->getUserProperty(), 'brains')],
            'sentimentType' => ['required', Rule::in(Analyser::VALID_TYPES)],
            'file' => ['required', 'file']
        ];
    }
}
