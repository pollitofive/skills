<?php

namespace Tests\Feature;

use App\Http\Livewire\ChangePassword;
use App\Models\User;
use Illuminate\Support\Facades\{Auth,Hash};
use Livewire\Livewire;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    /** @test */
    public function main_page_contains_change_password_form_livewire_component()
    {
        $this->get('change-password')->assertSeeLivewire('change-password');
    }

    /** @test */
    public function can_change_password()
    {
        Livewire::test(ChangePassword::class)
            ->set('old_password','12345678')
            ->set('new_password','87654321')
            ->set('new_password_confirmation','87654321')
            ->call('submitForm')
            ->assertSee('New password successfully saved.');
        $user = User::find(Auth::user()->id);

        $this->assertTrue(Hash::check('87654321',
            $user->password));
    }

    /** @test */
    public function validate_required_data()
    {
        Livewire::test(ChangePassword::class)
            ->set('old_password','')
            ->set('new_password','')
            ->call('submitForm')
            ->assertSee('The old password field is required.')
            ->assertSee('The new password field is required.');
    }

    /** @test */
    public function validate_min_characters()
    {
        Livewire::test(ChangePassword::class)
            ->set('old_password','12345678')
            ->set('new_password','12345')
            ->set('new_password_confirmation','12345')
            ->call('submitForm')
            ->assertSee('The new password must be at least 6 characters.');
    }

    /** @test */
    public function validate_new_password_and_confirmation_must_be_same()
    {
        Livewire::test(ChangePassword::class)
            ->set('old_password','12345678')
            ->set('new_password','123456')
            ->set('new_password_confirmation','123457')
            ->call('submitForm')
            ->assertSee('The new password confirmation does not match.');
    }

    /** @test */
    public function validate_new_password_should_be_different_from_the_lastone()
    {
        Livewire::test(ChangePassword::class)
            ->set('old_password','12345678')
            ->set('new_password','12345678')
            ->set('new_password_confirmation','12345678')
            ->call('submitForm')
            ->assertSee('The new password and old password must be different.');
    }

    /** @test */
    public function validate_old_password_is_correct()
    {
        Livewire::test(ChangePassword::class)
            ->set('old_password','12345687')
            ->set('new_password','123456789')
            ->set('new_password_confirmation','123456789')
            ->call('submitForm')
            ->assertSee('The old password doesn\'t match.');
    }

}
