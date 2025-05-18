<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'password.min' => 'Пароль должен содержать минимум 8 символов!',
        ]);
        

        $userData = $request->all();
        $userData += ["is_admin" => 0];
        $user = User::create($userData);
        Auth::login($user);
        event(new Registered($user));
        $cacheKey = "user_cooldown_{$user->id}";
        Cache::put($cacheKey, time() + 60, 60);
        return redirect()->route('verification.notice');
    }

    public function login()
    {
        return view('user.login');
    }

    public function loginAuth(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ], [
            'email.required' => 'Пожалуйста, укажите email',
            'password.required' => 'Пожалуйста, укажите пароль',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return  back()->withErrors([
           'error' => 'Неверный email или пароль',
        ])->withInput($request->only('email', 'remember'));
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function forgotPasswordStore(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPasswordUpdate(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
