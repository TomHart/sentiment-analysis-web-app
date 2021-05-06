<?php

namespace Tests\Fortify;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Brain;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

class CreateNewUserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @throws ValidationException
     */
    public function test_created_user_links_to_default_brain()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'email@example.com',
            'password' => '1234!@£$abcd',
            'password_confirmation' => '1234!@£$abcd',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ];

        $defaultBrain = Brain::create(
            [
                'name' => 'Default Brain'
            ]
        );

        $sut = new CreateNewUser();
        $user = $sut->create($data);

        self::assertTrue($defaultBrain->is($user->brains->first()));
    }
}
