<?php
declare(strict_types=1);

namespace App\SentimentAnalysis;

use App\Models\Brain;
use App\Models\Sentence;
use App\Models\Word;
use App\SentimentAnalysis\Memories\DatabaseLoader;
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
    private ?Brain $brain;

    /** @var Sentence */
    private Sentence $currentSentence;

    /**
     * DatabaseBrain constructor.
     * @param Brain|null $brain
     * @param LoaderInterface|null $loader
     */
    public function __construct(Brain $brain = null, LoaderInterface $loader = null)
    {
        if (is_null($loader)) {
            $loader = new NoopLoader();
        }

        if (!is_null($brain)) {
            $this->brain = $brain;
            $this->loadMemories($loader);
        }
    }

    /**
     * @param Brain $brain
     * @return BrainInterface
     */
    public function setBrain(Brain $brain): BrainInterface
    {
        $this->brain = $brain;
        $loader = new DatabaseLoader($brain);
        $this->loadMemories($loader);
        return $this;
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
