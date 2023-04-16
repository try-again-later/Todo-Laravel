<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\RedirectResponse;

class RegistrationController extends Controller
{
    public function store(RegistrationRequest $request): RedirectResponse
    {
        $validatedCredentials = $request->validated();

        User::create([
            'name' => $validatedCredentials['name'],
            'email' => $validatedCredentials['email'],
            'password' => Hash::make($validatedCredentials['password']),
        ]);

        return redirect()->route('home');
    }
}
