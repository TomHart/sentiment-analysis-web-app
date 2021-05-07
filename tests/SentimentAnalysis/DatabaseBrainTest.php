<?php
declare(strict_types=1);

namespace Tests\SentimentAnalysis;

use App\Models\Brain;
use App\Models\Sentence;
use App\Models\Word;
use App\SentimentAnalysis\DatabaseBrain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TomHart\SentimentAnalysis\SentimentType;

/**
 * Class DatabaseBrainTest
 * @package Tests\SentimentAnalysis
 */
class DatabaseBrainTest extends TestCase
{
    use RefreshDatabase;

    private Brain|Model $defaultBrain;
    private DatabaseBrain $sut;


    public function testTrainingTheBrain(): void
    {
        $file = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'test.txt');
        $this->sut->insertTrainingData($file, SentimentType::POSITIVE, 1000);

        $sentences = Sentence::all();
        $words = Word::all();

        $expectedSentences = [
            [
                'id' => 1,
                'sentence' => 'that was amazing',
                'sentiment' => SentimentType::POSITIVE,
                'brain_id' => '1'
            ],
            [
                'id' => 2,
                'sentence' => 'this is great',
                'sentiment' => SentimentType::POSITIVE,
                'brain_id' => '1'
            ]
        ];

        $expectedWords = [
            [
                'id' => 1,
                'word' => 'that',
                'sentiment' => SentimentType::POSITIVE,
                'sentence_id' => '1'
            ],
            [
                'id' => 2,
                'word' => 'was',
                'sentiment' => SentimentType::POSITIVE,
                'sentence_id' => '1'
            ],
            [
                'id' => 3,
                'word' => 'amazing',
                'sentiment' => SentimentType::POSITIVE,
                'sentence_id' => '1'
            ],
            [
                'id' => 4,
                'word' => 'this',
                'sentiment' => SentimentType::POSITIVE,
                'sentence_id' => '2'
            ],
            [
                'id' => 5,
                'word' => 'is',
                'sentiment' => SentimentType::POSITIVE,
                'sentence_id' => '2'
            ],
            [
                'id' => 6,
                'word' => 'great',
                'sentiment' => SentimentType::POSITIVE,
                'sentence_id' => '2'
            ]
        ];


        static::assertSame($expectedSentences, $sentences->toArray());
        static::assertSame($expectedWords, $words->toArray());

        // Assert the brain contains the same words, this method ignores the pivot keys
        static::assertDiffEmpty($expectedWords, $this->defaultBrain->words->toArray());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultBrain = Brain::create(
            [
                'name' => 'Default Brain'
            ]
        );

        $this->sut = new DatabaseBrain($this->defaultBrain);
    }
}
