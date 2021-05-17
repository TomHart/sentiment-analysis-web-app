<?php
declare(strict_types=1);

namespace Tests\Policies;

use App\Models\Team;
use App\Models\User;
use App\Policies\TeamPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * TeamPolicyTest Class Test
 * @package Tests\Policies
 */
class TeamPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_view_any(): void
    {
        $sut = new TeamPolicy();
        self::assertTrue($sut->viewAny(new User()));
    }

    public function test_view(): void
    {
        $user = $this->createUser();
        $team = new Team();
        $team->name = 'Team Name';
        $team->owner()->associate($user);
        $team->personal_team = false;
        $team->save();
        $team->users()->save($user);

        $sut = new TeamPolicy();
        self::assertTrue($sut->view($user, $team));
    }
}
