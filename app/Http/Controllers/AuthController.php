<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Credenciales incorrectas.'])
                ->onlyInput('email');
        }

        // Verifica que el usuario esté activo
        $user = Auth::user();
        if (($user->status->status_name ?? null) !== 'Activo') {
            Auth::logout();
            return back()->withErrors(['email' => 'Tu usuario está inactivo. Contacta al administrador.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Formulario para pedir el enlace de recuperación (solo correo).
     */
    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Envía el correo con el enlace para restablecer la contraseña.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Solo se envía a usuarios activos. La respuesta es siempre la misma
        // para no revelar si un correo está registrado o no.
        if ($user && ($user->status->status_name ?? null) === 'Activo') {
            Password::sendResetLink($request->only('email'));
        }

        return back()->with(
            'success',
            'Si el correo está registrado, te enviamos un enlace para restablecer tu contraseña. Revisa tu bandeja de entrada (y el spam).'
        );
    }

    /**
     * Formulario para escribir la nueva contraseña (llega desde el enlace del correo).
     */
    public function showResetForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Guarda la nueva contraseña.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password'       => $password, // el cast 'hashed' la encripta
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('success', 'Contraseña actualizada. Ya puedes iniciar sesión.');
        }

        return back()
            ->withErrors(['email' => 'El enlace es inválido o ya expiró. Solicita uno nuevo.'])
            ->onlyInput('email');
    }
}
