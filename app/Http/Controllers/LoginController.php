<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function store(LoginRequest $request): RedirectResponse
    {
        $validatedCredentials = $request->validated();

        if (Auth::attempt($validatedCredentials, remember: isset($validatedCredentials['remember_me']))) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Некорректные почта или пароль',
        ])->onlyInput('email');
    }

    public function delete(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
