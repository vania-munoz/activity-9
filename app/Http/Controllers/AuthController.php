<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function register(Request $request)
    {
        $request->validate(
            [
                'name'=> 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',

            ]);
        User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

        return redirect('/login')->with('success', 'Usuario creado correctamente');
    }
    
    public function login(Request $request)
    {
        //lo que se usara para validar
        $credentials = $request->validate(
        [
            'email'=> 'required|email',
            'password'=> 'required',
        ]);
        //intento de login si todo esta bien 
        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }
        //si no es valido nos manda atras
        return back()->withErrors(['email'=>"Credenciales incorrectas"])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    
}
