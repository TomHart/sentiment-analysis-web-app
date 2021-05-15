<?php
declare(strict_types=1);

namespace App\SentimentAnalysis\Memories;

use App\Models\Brain;
use Illuminate\Support\Facades\DB;
use TomHart\SentimentAnalysis\Brain\AbstractBrain;
use TomHart\SentimentAnalysis\Memories\LoaderInterface;

/**
 * Class DatabaseLoader
 * @package App\SentimentAnalysis\Memories
 */
class DatabaseLoader implements LoaderInterface
{
    private ?Brain $brain;

    /**
     * DatabaseLoader constructor.
     * @param Brain|null $brain
     */
    public function __construct(Brain $brain = null)
    {
        if (!is_null($brain)) {
            $this->setBrain($brain);
        }
    }

    /**
     * @param Brain $brain
     */
    public function setBrain(Brain $brain): void
    {
        $this->brain = $brain;
    }

    /**
     * @inheritDoc
     */
    public function getSentiments(): array
    {
        $sql = 'select
                    `word`,
                    `sentiment`,
                    count(words.id) as total
                from
                     `words`
                inner join
                    `brain_word`
                        on `words`.`id` = `brain_word`.`word_id`
                        and `brain_word`.`brain_id` = ?
                group by
                    `word`, `sentiment`';

        $data = DB::select(DB::raw($sql), [$this->brain->id]);

        $response = [];

        foreach ($data as $word) {
            if (!isset($response[$word->word])) {
                $response[$word->word] = AbstractBrain::format([]);
            }

            $response[$word->word] = array_merge($response[$word->word], [
                $word->sentiment => (int)$word->total
            ]);
        }

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function getWordType(): array
    {
        return $this->brain
            ->words()
            ->select('sentiment', DB::raw('count(*) as total'))
            ->groupBy('sentiment')
            ->get()
            ->mapWithKeys(static function ($data) {
                return [
                    $data->sentiment => (int)$data->total
                ];
            })
            ->sortKeysDesc()
            ->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getSentenceType(): array
    {
        return $this->brain
            ->sentences()
            ->select('sentiment', DB::raw('count(*) as total'))
            ->groupBy('sentiment')
            ->get()
            ->mapWithKeys(static function ($data) {
                return [
                    $data->sentiment => (int)$data->total
                ];
            })
            ->sortKeysDesc()
            ->toArray();
    }
}
