<?php

namespace App\Livewire;

use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    public string $message;

    public string $old_password;

    public string $new_password;

    public string $new_password_confirmation;

    public function rules(): array
    {
        return [
            'old_password' => ['required', 'min:6', new MatchOldPassword],
            'new_password' => ['required', 'min:6', 'confirmed', 'different:old_password'],
        ];
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.change-password');
    }

    public function submitForm(): void
    {
        $this->validate();

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->message = 'New password successfully saved.';
        $this->old_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
    }
}
