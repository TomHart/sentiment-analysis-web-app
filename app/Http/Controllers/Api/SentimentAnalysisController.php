<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnalysisRequest;
use App\Models\AnalysisResult;
use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use TomHart\SentimentAnalysis\Analyser\AnalyserInterface;

/**
 * Class SentimentAnalysisController
 * @package App\Http\Controllers\Api
 */
class SentimentAnalysisController extends Controller
{
    /**
     * @param AnalysisRequest $request
     * @return Response
     * @throws BindingResolutionException
     */
    public function analyse(AnalysisRequest $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        /** @var PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        $brain = $token->brain;

        $analyser = app()->make(AnalyserInterface::class,
            [
                'brain' => $brain
            ]
        );

        $result = $analyser->analyse($request->input('text'));

        $analysisResult = new AnalysisResult();
        $analysisResult->sentence = $request->input('text');
        $analysisResult->brain()->associate($token->brain);
        $analysisResult->result = $result->getResult();
        $analysisResult->positive_accuracy = $result->getPositiveAccuracy();
        $analysisResult->negative_accuracy = $result->getNegativeAccuracy();
        $analysisResult->workings = $result->getWorkings();
        $analysisResult->save();

        return response($result);
    }
}
