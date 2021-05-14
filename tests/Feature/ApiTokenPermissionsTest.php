<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Livewire\ApiTokenManager;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Class ApiTokenPermissionsTest
 * @package Tests\Feature
 */
class ApiTokenPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_token_permissions_can_be_updated(): void
    {
        if (! Features::hasApiFeatures()) {
            self::markTestSkipped('API support is not enabled.');
        }

        if (Features::hasTeamFeatures()) {
            $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        } else {
            $this->actingAs($user = User::factory()->create());
        }

        $token = $user->tokens()->create([
            'name' => 'Test Token',
            'token' => Str::random(40),
            'abilities' => ['create', 'read'],
        ]);

        Livewire::test(ApiTokenManager::class)
                    ->set(['managingPermissionsFor' => $token])
                    ->set(['updateApiTokenForm' => [
                        'permissions' => [
                            'delete',
                            'missing-permission',
                        ],
                        'brain_id' => 1
                    ]])
                    ->call('updateApiToken');

        self::assertTrue($user->fresh()->tokens->first()->can('delete'));
        self::assertFalse($user->fresh()->tokens->first()->can('read'));
        self::assertFalse($user->fresh()->tokens->first()->can('missing-permission'));
    }
}
