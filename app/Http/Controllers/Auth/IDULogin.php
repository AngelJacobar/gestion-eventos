<?php

namespace App\Http\Controllers\Auth;

use App\Enums\EstatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class IDULogin extends Controller
{
    public function index()
    {
        return Socialite::driver('idu')->redirectUrl(config('services.idu.redirect'))->redirect();
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function login(Request $request)
    {
        $usuarioIDU = Socialite::driver('idu')->redirectUrl(config('services.idu.redirect'))->user();
        $curp = Str::upper($usuarioIDU->user['curp']);
        $usuario = Usuario::where('curp', $curp)->first();

        if (config('services.idu.register') && ! $usuario) {
            $usuario = Usuario::create([
                'nombre' => $usuarioIDU->user['firstName'],
                'primer_apellido' => $usuarioIDU->user['lastName'],
                'segundo_apellido' => $usuarioIDU->user['secondLastName'],
                'activo' => EstatusEnum::Activo,
                'email' => $usuarioIDU->user['unamEmail'],
                'curp' => $curp,
                'numero_cuenta' => $usuarioIDU->user['studentNumber'] ?? null,
                'numero_trabajador' => $usuarioIDU->user['employeeNumber'] ?? null,
                'password' => '',
            ]);
        }

        if (! $usuario) {
            return redirect()->route('login')
                ->withErrors(['idu' => 'No se encontró el usuario en la base de datos'])
                ->withInput();
        }

        if ($usuario->activo !== EstatusEnum::Activo) {
            return redirect()->route('login')
                ->withErrors(['idu' => 'Su cuenta de usuario ha sido inhabilitada. Le sugerimos ponerse en contacto con el administrador.'])
                ->withInput();
        }

        Auth::login($usuario);
        Session::put('IDUToken', $usuarioIDU->token);
        Session::put('IDUrefreshToken', $usuarioIDU->refreshToken);
        return redirect()->route('dashboard');
    }

    public static function logout()
    {
        $logoutUrl = Socialite::driver('idu')->getLogoutUrl();
        // Redirect the user to the Keycloak logout URL
        return redirect($logoutUrl);
    }
}
