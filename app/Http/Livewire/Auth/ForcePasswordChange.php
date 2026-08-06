<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ForcePasswordChange extends Component
{
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'password' => 'required|string|min:8|confirmed',
    ];

    protected $messages = [
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Passwords do not match.',
    ];

    public function changePassword()
    {
        $this->validate();

        $user = Auth::user();
        $user->password = Hash::make($this->password);
        $user->password_change = 0;
        $user->password_reset_otp = null;
        $user->password_reset_otp_expires_at = null;
        $user->save();

        session()->flash('success', 'Password changed successfully. Welcome to your dashboard!');

        return redirect()->route('admin.home');
    }

    public function render()
    {
        return view('livewire.auth.force-password-change')
            ->layout('layouts.admin.master');
    }
}
