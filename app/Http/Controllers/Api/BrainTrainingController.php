<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\BrainTrainingRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TomHart\SentimentAnalysis\Brain\StopWords;
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
        $brain = $this->getDatabaseBrain($request);

        $text = $request->input('text');
        $sentiment = $request->input('sentiment');

        $brain->insertTrainingSentence($text, $sentiment);

        return response([
            'total_words' => $brain->getWordCount(),
            'positive_words' => $brain->getWordTypeCount(SentimentType::POSITIVE),
            'negative_words' => $brain->getWordTypeCount(SentimentType::NEGATIVE),
        ]);
    }

    public function addStopWord(Request $request)
    {
        $brain = $this->getBrainModel($request);

        $settings = $brain->settings;
        $stopWords = [];

        foreach ($settings as $setting) {
            $stopWords = match ($setting->name) {
                'Use Default Stop Words' => array_merge($stopWords, StopWords::ENGLISH),
                'Custom Stop Words' => array_merge($stopWords, $setting->pivot->value),
            };
        }

        dump($settings, $stopWords);
    }
}
