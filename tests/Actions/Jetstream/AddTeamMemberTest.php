<?php
declare(strict_types=1);

namespace Tests\Actions\Jetstream;

use App\Actions\Jetstream\AddTeamMember;
use App\Models\Team;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

/**
 * AddTeamMemberTest Class Test
 * @package Tests\Actions\Jetstream
 */
class AddTeamMemberTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function test_adding_user_to_team(): void
    {
        $owner = $this->createUser();
        /** @var Team $team */
        $team = Team::factory()->create();
        $team->owner()->associate($owner);

        $email = 'test@example.com';
        $newUser = $this->createUser(['email' => $email]);
        $newUser->fresh();

        $sut = new AddTeamMember();
        $sut->add($owner, $team, $email, 'editor');

        self::assertModelInCollection($newUser, $team->users()->get());
    }
}
