<?php
declare(strict_types=1);

use App\Http\Controllers\Api\BrainTrainingController;
use App\Http\Controllers\Api\SentimentAnalysisController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(static function () {
    Route::get('analyse', [SentimentAnalysisController::class, 'analyse'])->name('analyse');
    Route::get('train', [BrainTrainingController::class, 'train'])->name('train');
    Route::get('stop-words', [BrainTrainingController::class, 'addStopWord'])->name('stop-words');
});
