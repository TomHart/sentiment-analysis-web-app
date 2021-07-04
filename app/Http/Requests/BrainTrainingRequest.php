<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;
use TomHart\SentimentAnalysis\SentimentType;

/**
 * @package App\Http\Requests
 *
 * @queryParam text string required The message to be analysed
 * @queryParam sentiment string required What type of sentence is it, 'positive', or 'negative'. Example: positive
 */
class BrainTrainingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    #[ArrayShape(['text' => 'string[]', 'sentiment' => 'array'])]
    public function rules(): array
    {
        return [
            'text' => ['required'],
            'sentiment' => ['required', Rule::in([SentimentType::POSITIVE, SentimentType::NEGATIVE])]
        ];
    }
}
