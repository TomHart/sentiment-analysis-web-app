<?php
declare(strict_types=1);

namespace Tests\Providers;

use App\Models\Brain;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TomHart\SentimentAnalysis\Analyser\Analyser;
use TomHart\SentimentAnalysis\Analyser\AnalyserInterface;

/**
 * AppServiceProviderTest Class Test
 * @package Tests\Providers
 */
class AppServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws BindingResolutionException
     */
    public function test_register(): void
    {
        $brain = new Brain(['name' => 'Test Name']);
        $brain->save();

        $analyser = $this->app->make(AnalyserInterface::class, [
            'brain' => $brain
        ]);

        self::assertInstanceOf(Analyser::class, $analyser);
    }
}
