<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brain;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\SentimentAnalysis\DatabaseBrain;
use Illuminate\Http\Request;

/**
 * Class AbstractController
 * @package App\Http\Controllers\Api
 */
abstract class AbstractApiController extends Controller
{
    /**
     * @param Request $request
     * @return DatabaseBrain
     */
    public function getDatabaseBrain(Request $request): DatabaseBrain
    {
        return $this->getBrainModel($request)->toBrain();
    }

    /**
     * @param Request $request
     * @return Brain
     */
    public function getBrainModel(Request $request): Brain
    {
        /** @var User $user */
        $user = $request->user();

        /** @var PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        return $token->brain;
    }
}
