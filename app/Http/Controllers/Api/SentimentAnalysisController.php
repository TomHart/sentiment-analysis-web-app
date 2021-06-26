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

        $result = $analyser->analyse($request->input('text'));

        $analysisResult = new AnalysisResult();
        $analysisResult->sentence = $request->input('text');
        $analysisResult->brain()->associate($brain);
        $analysisResult->result = $result->getResult();
        $analysisResult->positive_accuracy = $result->getPositiveAccuracy();
        $analysisResult->negative_accuracy = $result->getNegativeAccuracy();
        $analysisResult->workings = $result->getWorkings();
        $analysisResult->save();

        return response($result);
    }
}
