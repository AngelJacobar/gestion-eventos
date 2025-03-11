<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AccionEnum;
use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use App\Rules\MismaContrasena;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Masmerise\Toaster\Toaster;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), new MismaContrasena(), 'confirmed'],
        ], [], [
            'current_password' => 'Contraseña actual',
            'password' => 'Nueva contraseña',
            'password_confirmation' => 'Confirmar nueva contraseña',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        Bitacora::registrar(AccionEnum::CambioContrasena, $request->user()->id_usuario, null);

        Toaster::success('passwords.reset');
        return redirect()->route('dashboard');
    }
}
