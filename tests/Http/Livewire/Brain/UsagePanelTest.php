<?php
declare(strict_types=1);

namespace Tests\Http\Livewire\Brain;

use App\Http\Livewire\Brain\UsagePanel;
use App\Models\AnalysisResult;
use App\Models\Brain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use TomHart\SentimentAnalysis\SentimentType;

/**
 * UsagePanelTest Class Test
 * @package Tests\Http\Livewire\Brain
 */
class UsagePanelTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Brain $brain;

    public function test_can_group_results(): void
    {
        /** @var UsagePanel $component */
        $component = Livewire::test(UsagePanel::class, ['brain' => $this->brain]);

        $results = $component->monthlyUsage;

        self::assertEquals([
            date('m Y') => '1'
        ], $results);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->actingAs($this->user);
        $this->brain = new Brain(['name' => 'New Brain Name']);
        $this->brain->save();
        $this->brain->users()->save($this->user);
        $result = new AnalysisResult();
        $result->sentence = 'Test Sentence';
        $result->result = SentimentType::POSITIVE;
        $result->positive_accuracy = 0.5;
        $result->negative_accuracy = 0.5;
        $result->brain()->associate($this->brain);
        $result->save();
    }
}
