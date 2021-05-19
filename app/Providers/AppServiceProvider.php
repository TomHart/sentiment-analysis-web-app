<?php
declare(strict_types=1);

namespace App\Providers;

use App\Models\Brain;
use App\SentimentAnalysis\DatabaseBrain;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use JetBrains\PhpStorm\ArrayShape;
use TomHart\SentimentAnalysis\Analyser\Analyser;
use TomHart\SentimentAnalysis\Analyser\AnalyserInterface;
use TomHart\SentimentAnalysis\Brain\BrainInterface;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(AnalyserInterface::class, static function (
            Application $app,
            #[ArrayShape(['brain' => Brain::class])] array $params
        ) {
            $brain = $params['brain']->toBrain();

            $analyser = new Analyser();
            return $analyser->setBrain($brain);
        });
    }
}
