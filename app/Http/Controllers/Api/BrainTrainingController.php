<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\BrainTrainingRequest;
use Illuminate\Http\Response;
use TomHart\SentimentAnalysis\SentimentType;

/**
 * @package App\Http\Controllers\Api
 */
class BrainTrainingController extends AbstractApiController
{
    /**
     * Train the brain
     *
     * This endpoint allows you to insert some training data to your brain
     * <aside class="notice">The brain used is the one linked to your API key</aside>
     *
     * @param BrainTrainingRequest $request
     * @return Response
     */
    public function train(BrainTrainingRequest $request): Response
    {
        $brain = $this->getBrain($request);

        $text = $request->input('text');
        $sentiment = $request->input('sentiment');

        $brain->toBrain()->insertTrainingSentence($text, $sentiment);

        return response([
            'total_words' => $brain->toBrain()->getWordCount(),
            'positive_words' => $brain->toBrain()->getWordTypeCount(SentimentType::POSITIVE),
            'negative_words' => $brain->toBrain()->getWordTypeCount(SentimentType::NEGATIVE),
        ]);
    }

    public function addStopWord(BrainTrainingRequest $request)
    {
        $brain = $this->getBrain($request);

        //
    }
}
