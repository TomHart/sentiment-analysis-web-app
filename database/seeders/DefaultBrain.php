<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Brain;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Laravel\Jetstream\Jetstream;
use Throwable;

/**
 * Class DefaultBrain
 * @package Database\Seeders
 */
class DefaultBrain extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Throwable
     */
    public function run(): void
    {
        $user = (new CreateNewUser())->create([
            'name' => 'Tom Hart',
            'email' => 'tom.hart.221@gmail.com',
            'password' => 'Blink_182',
            'password_confirmation' => 'Blink_182',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? 'yes' : '',
        ]);

        $user->email_verified_at = Carbon::now();
        $user->save();

        $brain = Brain::firstOrCreate(
            [
                'name' => 'Default Brain'
            ]
        );

        $token = $user->createToken('Default Token', $brain->id);
        $token->accessToken->token = hash('sha256', $plainTextToken = env('TEST_TOKEN'));
        $token->accessToken->save();
    }
}
