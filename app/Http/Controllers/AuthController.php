<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Форма регистрации
    public function showRegister()
    {
        return view('auth.register');
    }

    // Регистрация пользователя
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'advertiser' // по умолчанию роль становится AVERTISER
        ]);

        Auth::login($user);

        return redirect('/offers');
    }

    // Форма входа
    public function showLogin()
    {
        return view('auth.login');
    }

    // Вход в систему
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/offers');
        }

        return back()->withErrors(['email' => 'Неверный email или пароль']);
    }

    // Выход из системы
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
