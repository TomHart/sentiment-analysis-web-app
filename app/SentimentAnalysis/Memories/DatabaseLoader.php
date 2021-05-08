<?php
declare(strict_types=1);

namespace App\SentimentAnalysis\Memories;

use App\Models\Brain;
use Illuminate\Database\Eloquent\Collection;
use TomHart\SentimentAnalysis\Brain\AbstractBrain;
use TomHart\SentimentAnalysis\Memories\LoaderInterface;

/**
 * Class DatabaseLoader
 * @package App\SentimentAnalysis\Memories
 */
class DatabaseLoader implements LoaderInterface
{

    private Brain $brain;

    /**
     * DatabaseLoader constructor.
     * @param Brain $brain
     */
    public function __construct(Brain $brain)
    {
        $this->brain = $brain;
    }

    /**
     * @inheritDoc
     */
    public function getSentiments(): array
    {
        $words = $this
            ->brain
            ->words
            ->groupBy('word')
            ->map(static function (Collection $data) {
                return AbstractBrain::format($data->countBy('sentiment')->toArray());
            });

        return $words->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getWordType(): array
    {
        return $this->brain->words->countBy('sentiment')->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getSentenceType(): array
    {
        return $this->brain->sentences->countBy('sentiment')->toArray();
    }
}
