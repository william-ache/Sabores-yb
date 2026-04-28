<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::updateOrCreate([
                'email' => $googleUser->email,
            ], [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'google_token' => $googleUser->token,
                // El password es nullable gracias a la migración
            ]);

            Auth::login($user);
            
            // Si el usuario es administrador, activamos la sesión de admin
            if ($user->role === 'admin') {
                session(['admin_logged_in' => true]);
                return redirect()->intended('/admin');
            }

            // Si es un cliente normal, va a su panel de cuenta
            return redirect()->route('customer.dashboard');

        } catch (\Exception $e) {
            \Log::error('Error en login con Google: ' . $e->getMessage());
            return redirect('/')->with('error', 'Hubo un error al iniciar sesión con Google: ' . $e->getMessage());
        }
    }
}
