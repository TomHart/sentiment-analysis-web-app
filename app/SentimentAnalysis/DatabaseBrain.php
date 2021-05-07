<?php
declare(strict_types=1);

namespace App\SentimentAnalysis;

use App\Models\Brain;
use App\Models\Sentence;
use App\Models\Word;
use TomHart\SentimentAnalysis\Brain\Brain as AIBrain;
use TomHart\SentimentAnalysis\Brain\BrainInterface;
use TomHart\SentimentAnalysis\Memories\LoaderInterface;
use TomHart\SentimentAnalysis\Memories\NoopLoader;

/**
 * Class DatabaseBrain
 * @package App\SentimentAnalysis
 */
class DatabaseBrain extends AIBrain
{
    private Brain $brain;

    private Sentence $currentSentence;

    /**
     * DatabaseBrain constructor.
     * @param Brain $brain
     * @param LoaderInterface|null $loader
     */
    public function __construct(Brain $brain, LoaderInterface $loader = null)
    {
        $this->brain = $brain;
        if(is_null($loader)){
            $loader = new NoopLoader();
        }

        $this->loadMemories($loader);
    }

    /**
     * @param string $word
     * @param string $wordType
     * @return BrainInterface
     */
    public function addSentiment(string $word, string $wordType): BrainInterface
    {
        $model = new Word();
        $model->word = $word;
        $model->sentiment = $wordType;
        $model->sentence()->associate($this->currentSentence);
        $model->save();
        $model->brains()->save($this->brain);

        return parent::addSentiment($word, $wordType);
    }

    /**
     * @param string $sentence
     * @param string $sentenceType
     * @return BrainInterface
     */
    public function addSentence(string $sentence, string $sentenceType): BrainInterface
    {
        $model = new Sentence();
        $model->sentence = $sentence;
        $model->sentiment = $sentenceType;
        $model->brain()->associate($this->brain);
        $model->save();
        $this->currentSentence = $model;

        return parent::addSentence($sentence, $sentenceType);
    }
}
