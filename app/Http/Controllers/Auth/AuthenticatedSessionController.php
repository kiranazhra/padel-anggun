<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     */
    public function create(): View
    {
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi salah.',
            ]);
        }

        // Prevent session fixation attacks.
        $request->session()->regenerate();

        /** @var User $user */
        $user = Auth::user();

        // Akun admin: hormati intended URL dan arahkan ke panel admin.
        if ($user instanceof User && $user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Untuk user customer, langsung arahkan ke `dashboard` tanpa
        // meneruskan ke `intended`, sehingga pengalaman selalu menuju
        // ke halaman dashboard setelah login.
        return redirect()->route('dashboard');
    }

    /**
     * Log the user out of the application.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
