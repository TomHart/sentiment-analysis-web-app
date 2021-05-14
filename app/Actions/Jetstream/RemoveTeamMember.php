<?php
declare(strict_types=1);

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Events\TeamMemberRemoved;

/**
 * Class RemoveTeamMember
 * @package App\Actions\Jetstream
 */
class RemoveTeamMember implements RemovesTeamMembers
{
    /**
     * Remove the team member from the given team.
     *
     * @param mixed $user
     * @param mixed $team
     * @param mixed $teamMember
     * @return void
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function remove($user, $team, $teamMember): void
    {
        $this->authorize($user, $team, $teamMember);

        $this->ensureUserDoesNotOwnTeam($teamMember, $team);

        $team->removeUser($teamMember);

        TeamMemberRemoved::dispatch($team, $teamMember);
    }

    /**
     * Authorize that the user can remove the team member.
     *
     * @param User $user
     * @param Team $team
     * @param User $teamMember
     * @return void
     * @throws AuthorizationException
     */
    protected function authorize(User $user, Team $team, User $teamMember): void
    {
        if ($user->id !== $teamMember->id && !Gate::forUser($user)->check('removeTeamMember', $team)) {
            throw new AuthorizationException();
        }
    }

    /**
     * Ensure that the currently authenticated user does not own the team.
     *
     * @param User $teamMember
     * @param Team $team
     * @return void
     * @throws ValidationException
     */
    protected function ensureUserDoesNotOwnTeam(User $teamMember, Team $team): void
    {
        if ($teamMember->id === $team->owner->id) {
            throw ValidationException::withMessages([
                'team' => [__('You may not leave a team that you created.')],
            ])->errorBag('removeTeamMember');
        }
    }
}
