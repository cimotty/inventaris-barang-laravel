<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateProfile extends Component
{   
    public $user;
    public $nama, $email, $kataSandiLama, $kataSandi, $konfirmasiKataSandi;
    public $state = [];
    public $showPassword = false;

    // Show Password
    public function toggleShowPassword()
    {
        $this->showPassword = !$this->showPassword;
    }
    // End Show Password

    // Validation
    protected $rules = [
        'nama' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:3', 'max:50'],
        'email' => ['required', 'unique:users', 'email:rfc,dns', 'max:50'],
        'kataSandiLama' => ['required', 'not_regex:/\s/'],
        'kataSandi' => ['required', 'not_regex:/\s/', 'min:5'],
        'konfirmasiKataSandi' => ['same:kataSandi'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    // End Validation

    // Update Profile
    public function updateProfile()
    {
        $validatedData = $this->validate([
            'nama' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:3', 'max:50'],
            'email' => ['required', 'unique:users,email,'.auth()->user()->id, 'email:rfc,dns', 'max:50'],
        ]);

        auth()->user()->update([
            'name' => ($validatedData['nama']),
            'email' => ($validatedData['email']),
        ]);

        session()->flash('successMessage', 'Profil berhasil diperbarui!');
    }
    // End Update Profile

    // Change Password
    public function changePassword()
    {
        $validatedData = $this->validate([
            'kataSandiLama' => ['required', 'not_regex:/\s/'],
            'kataSandi' => ['required', 'not_regex:/\s/', 'min:5'],
            'konfirmasiKataSandi' => ['same:kataSandi'],
        ]);

        $currentPassword = auth()->user()->password;

        if (!Hash::check($validatedData['kataSandiLama'], $currentPassword)) {
            $this->addError('kataSandiLama', 'Kata sandi lama salah.');
            return;
        }

        auth()->user()->update([
            'password' => bcrypt($validatedData['kataSandi']),
        ]);

        $this->kataSandiLama = '';
        $this->kataSandi = '';
        $this->konfirmasiKataSandi = '';

        session()->flash('successMessage', 'Kata sandi berhasil diperbarui!');
    }
    // End Change Password

    public function render()
    {
        $user = User::where('id', auth()->user()->id)->first();

        if ($this->nama === null) {
            $this->nama = $user->name;
        }
        if ($this->email === null) {
            $this->email = $user->email;
        }

        return view('livewire.update-profile');
    }
}
