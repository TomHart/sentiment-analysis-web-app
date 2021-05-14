<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Livewire\ApiTokenManager;
use App\Models\Brain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Class CreateApiTokenTest
 * @package Tests\Feature
 */
class CreateApiTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_tokens_can_be_created(): void
    {
        if (! Features::hasApiFeatures()) {
            self::markTestSkipped('API support is not enabled.');
        }

        if (Features::hasTeamFeatures()) {
            $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        } else {
            $this->actingAs($user = User::factory()->create());
        }

        $brain = new Brain();
        $brain->name = 'Test';
        $brain->save();

        Livewire::test(ApiTokenManager::class)
                    ->set(['createApiTokenForm' => [
                        'name' => 'Test Token',
                        'permissions' => [
                            'read',
                            'update',
                        ],
                        'brain_id' => $brain->id
                    ]])
                    ->call('createApiToken');

        self::assertCount(1, $user->fresh()->tokens);
        self::assertEquals('Test Token', $user->fresh()->tokens->first()->name);
        self::assertTrue($user->fresh()->tokens->first()->can('read'));
        self::assertFalse($user->fresh()->tokens->first()->can('delete'));
    }
}
