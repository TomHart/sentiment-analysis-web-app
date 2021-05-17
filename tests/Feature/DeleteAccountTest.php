<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\DeleteUserForm;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Class DeleteAccountTest
 * @package Tests\Feature
 */
class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_accounts_can_be_deleted(): void
    {
        if (!Features::hasAccountDeletionFeatures()) {
            self::markTestSkipped('Account deletion is not enabled.');
        }

        $this->actingAs($user = $this->createUser());

        Livewire::test(DeleteUserForm::class)
            ->set('password', 'password')
            ->call('deleteUser');

        self::assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_before_account_can_be_deleted(): void
    {
        if (!Features::hasAccountDeletionFeatures()) {
            self::markTestSkipped('Account deletion is not enabled.');
        }

        $this->actingAs($user = $this->createUser());

        Livewire::test(DeleteUserForm::class)
            ->set('password', 'wrong-password')
            ->call('deleteUser')
            ->assertHasErrors(['password']);

        self::assertNotNull($user->fresh());
    }

    public function test_owned_teams_deleted(): void
    {
        if (!Features::hasAccountDeletionFeatures()) {
            self::markTestSkipped('Account deletion is not enabled.');
        }

        $this->actingAs($user = $this->createUser());
        $team = Team::factory()->create();
        $user->ownedTeams()->save($team);

        Livewire::test(DeleteUserForm::class)
            ->set('password', 'password')
            ->call('deleteUser');

        self::assertNull($user->fresh());
        $this->assertDeleted($team);
    }
}
