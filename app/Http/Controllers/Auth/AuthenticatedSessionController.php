<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AccionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Bitacora;
use App\Rules\ReCaptcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => [new ReCaptcha()],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $request->authenticate();

        $request->session()->regenerate();

        Bitacora::registrar(AccionEnum::InicioSesion, Auth::id(), null);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userId = Auth::id();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Bitacora::registrar(AccionEnum::CierreSesion, $userId, null);

        return redirect('/');
    }
}
