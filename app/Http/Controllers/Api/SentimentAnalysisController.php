<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnalysisRequest;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\SentimentAnalysis\DatabaseBrain;
use App\SentimentAnalysis\Memories\DatabaseLoader;
use Illuminate\Http\Response;
use TomHart\SentimentAnalysis\Analyser\Analyser;

/**
 * Class SentimentAnalysisController
 * @package App\Http\Controllers\Api
 */
class SentimentAnalysisController extends Controller
{
    /**
     * @param AnalysisRequest $request
     * @return Response
     */
    public function analyse(AnalysisRequest $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        /** @var PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        $brain = $token->brain;

        $brain = new DatabaseBrain($brain, new DatabaseLoader($brain));
        //dd($brain->getSentenceCount(), $brain->wordType, $brain->sentenceType, $brain->getSentiments());

        $analyser = new Analyser();
        $analyser->setBrain($brain);

        return response($analyser->analyse($request->input('text')));
    }
}
