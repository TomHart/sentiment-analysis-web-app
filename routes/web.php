<?php
declare(strict_types=1);

use App\Http\Controllers\BrainController;
use App\Http\Controllers\Dashboard\NotificationsController;
use App\Models\Brain;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'as' => 'consumer.'
],
    static function () {
        Route
            ::get(
                '/',
                static function () {
                    return view('welcome',
                        [
                            'brain' => Brain::where('name', 'Default Brain')->first()
                        ]
                    );
                }
            )
            ->name('index');

        Route
            ::get(
                '/contact',
                static function () {
                    return 'Coming...';
                }
            )
            ->name('contact');
    });

Route
    ::middleware(['auth:sanctum', 'verified'])
    ->group(
        static function () {

            Route::get(
                '/dashboard',
                function () {
                    return view('dashboard');
                }
            )->name('dashboard');

            Route::resource('brains', BrainController::class);

            Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications');
        }
    );
