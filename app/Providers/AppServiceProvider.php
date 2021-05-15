<?php
declare(strict_types=1);

namespace App\Providers;

use App\SentimentAnalysis\DatabaseBrain;
use App\SentimentAnalysis\Memories\DatabaseLoader;
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
            #[ArrayShape(['brain' => BrainInterface::class])] array $params
        ) {
            $loader = new DatabaseLoader($params['brain']);
            $brain = new DatabaseBrain($params['brain'], $loader);
            $analyser = new Analyser();
            return $analyser->setBrain($brain);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
