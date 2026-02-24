<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $request->authenticate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            AuditService::logLoginAttempt($request->input('email'), false);
            throw $e;
        }

        $user = Auth::user();

        if (!$user->hasHrAccess()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'You do not have permission to access the HR system.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        AuditService::logLoginAttempt($request->input('email'), true);

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        AuditService::logLogout();

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
