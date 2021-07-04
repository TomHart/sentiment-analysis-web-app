<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @package App\Http\Requests
 *
 * @queryParam text string required The message to be analysed
 */
class AnalysisRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    #[ArrayShape(['text' => 'string[]'])]
    public function rules(): array
    {
        return [
            'text' => ['required']
        ];
    }
}
