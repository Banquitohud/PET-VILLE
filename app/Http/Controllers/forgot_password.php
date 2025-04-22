<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail; // Asegúrate de usar el facade Mail

class forgot_password extends Controller
{
    public function index()
    {
        return view('auth.password'); // auth.password.blade.php
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Establece la dirección del remitente solo para esta acción
        $fromEmail = 'PetVille2609@outlook.com';  // Correo de envío
        $fromName = 'Pet Ville';  // Nombre del remitente

        // Configura el remitente dinámicamente para este envío de correo
        Mail::send([], [], function ($message) use ($request, $fromEmail, $fromName) {
            $message->from($fromEmail, $fromName)
                    ->to($request->email)
                    ->subject('Restablecer contraseña')
                    ->setBody('Haz clic en el siguiente enlace para restablecer tu contraseña.');
        });

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
