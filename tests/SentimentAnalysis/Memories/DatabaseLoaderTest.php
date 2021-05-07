<?php
declare(strict_types=1);

namespace Tests\SentimentAnalysis\Memories;

use App\Models\Brain;
use App\Models\Sentence;
use App\Models\Word;
use App\SentimentAnalysis\Memories\DatabaseLoader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TomHart\SentimentAnalysis\SentimentType;
use TomHart\SentimentAnalysis\StrUtils;

/**
 * Class DatabaseLoaderTest
 * @package Tests\SentimentAnalysis\Memories
 */
class DatabaseLoaderTest extends TestCase
{
    use RefreshDatabase;

    private DatabaseLoader $sut;

    public function testGetSentiments(): void
    {
        $expectedResult = [
            'this' => [
                'positive' => 1,
                'negative' => 1,
            ],
            'is' => [
                'positive' => 1,
                'negative' => 1,
            ],
            'great' => [
                'positive' => 1,
                'negative' => 0,
            ],
            'that' => [
                'positive' => 1,
                'negative' => 1,
            ],
            'was' => [
                'positive' => 1,
                'negative' => 1,
            ],
            'awesome' => [
                'positive' => 1,
                'negative' => 0,
            ],
            'terrible' => [
                'positive' => 0,
                'negative' => 1,
            ],
            'bad' => [
                'positive' => 0,
                'negative' => 1,
            ],
        ];

        self::assertSame($expectedResult, $this->sut->getSentiments());
    }

    public function testGetWordType(): void
    {
        $output = $this->sut->getWordType();

        $expected = [
            SentimentType::POSITIVE => 6,
            SentimentType::NEGATIVE => 6
        ];

        self::assertSame($expected, $output);
    }

    public function testGetSentenceType(): void
    {
        $output = $this->sut->getSentenceType();

        $expected = [
            SentimentType::POSITIVE => 2,
            SentimentType::NEGATIVE => 2
        ];

        self::assertSame($expected, $output);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $defaultBrain = Brain::create(
            [
                'name' => 'Default Brain'
            ]
        );

        $positiveSentences = ['this is great', 'that was awesome'];
        $negativeSentences = ['this is terrible', 'that was bad'];

        foreach ($positiveSentences as $sentence) {

            $sentenceModel = new Sentence();
            $sentenceModel->sentence = $sentence;
            $sentenceModel->sentiment = SentimentType::POSITIVE;
            $sentenceModel->brain()->associate($defaultBrain);
            $sentenceModel->save();

            $words = StrUtils::splitSentence($sentence);

            foreach ($words as $word) {
                $wordModel = new Word();
                $wordModel->word = $word;
                $wordModel->sentiment = SentimentType::POSITIVE;
                $wordModel->sentence()->associate($sentenceModel);
                $wordModel->save();
                $wordModel->brains()->save($defaultBrain);
            }
        }

        foreach ($negativeSentences as $sentence) {

            $sentenceModel = new Sentence();
            $sentenceModel->sentence = $sentence;
            $sentenceModel->sentiment = SentimentType::NEGATIVE;
            $sentenceModel->brain()->associate($defaultBrain);
            $sentenceModel->save();

            $words = StrUtils::splitSentence($sentence);

            foreach ($words as $word) {
                $wordModel = new Word();
                $wordModel->word = $word;
                $wordModel->sentiment = SentimentType::NEGATIVE;
                $wordModel->sentence()->associate($sentenceModel);
                $wordModel->save();
                $wordModel->brains()->save($defaultBrain);
            }
        }

        $this->sut = new DatabaseLoader($defaultBrain);
    }
}
