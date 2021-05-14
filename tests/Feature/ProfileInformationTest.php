<?php
declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Class ProfileInformationTest
 * @package Tests\Feature
 */
class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_profile_information_is_available(): void
    {
        $this->actingAs($user = $this->createUser());

        /** @var UpdateProfileInformationForm $component */
        $component = Livewire::test(UpdateProfileInformationForm::class);

        self::assertEquals($user->name, $component->state['name']);
        self::assertEquals($user->email, $component->state['email']);
    }

    public function test_profile_information_can_be_updated(): void
    {
        $this->actingAs($user = $this->createUser());

        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', [
                'name' => 'Test Name',
                'email' => 'test@example.com'
            ])
            ->call('updateProfileInformation');

        self::assertEquals('Test Name', $user->fresh()->name);
        self::assertEquals('test@example.com', $user->fresh()->email);
    }

    public function test_photo_can_be_updated(): void
    {
        $this->actingAs($user = $this->createUser());

        $photo = UploadedFile::fake()->create('me.jpg');

        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state.photo', $photo)
            ->call('updateProfileInformation');

        self::assertNotNull('Test Name', $user->fresh()->profile_photo_path);
    }

    public function test_name_can_be_updated(): void
    {
        $this->actingAs($user = $this->createUser());

        $originalEmail = $user->email;

        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['name' => 'Test Name', 'email' => $originalEmail])
            ->call('updateProfileInformation');

        self::assertEquals('Test Name', $user->fresh()->name);
        self::assertSame($originalEmail, $user->fresh()->email);
    }
}
