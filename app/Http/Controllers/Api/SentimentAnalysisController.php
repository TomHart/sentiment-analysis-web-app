<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\AnalysisRequest;
use App\Models\AnalysisResult;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use TomHart\SentimentAnalysis\Analyser\AnalyserInterface;

/**
 * Class SentimentAnalysisController
 * @package App\Http\Controllers\Api
 */
class SentimentAnalysisController extends AbstractApiController
{
    /**
     * @param AnalysisRequest $request
     * @return Response
     * @throws BindingResolutionException
     */
    public function analyse(AnalysisRequest $request): Response
    {
        $brain = $this->getBrain($request);

        $analyser = app()->make(AnalyserInterface::class,
            [
                'brain' => $brain
            ]
        );

        $text = $request->input('text');

        $result = $analyser->analyse($text);

        (new AnalysisResult([
            'sentence' => $text,
            'brain_id' => $brain->id,
            'result' => $result->getResult(),
            'positive_accuracy' => $result->getPositiveAccuracy(),
            'negative_accuracy' => $result->getNegativeAccuracy(),
            'workings' => $result->getWorkings(),
        ]))->save();

        return response($result);
    }
}
