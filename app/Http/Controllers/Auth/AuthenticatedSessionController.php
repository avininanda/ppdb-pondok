<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\PeriodePendaftaran;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $pendaftaranDibuka = PeriodePendaftaran::where('is_aktif', true)->exists(); 
        return view('auth.login', compact('pendaftaranDibuka'));
    }



    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    // Cek role user yang baru login
    // lalu arahkan ke dashboard yang sesuai
    $user = auth()->user();

    if ($user->isPanitia()) {
        return redirect()->route('panitia.dashboard');
    }

    if ($user->isPimpinan()) {
        return redirect()->route('pimpinan.dashboard');
    }

    if ($user->isCalonSantri()) {
        return redirect()->route('santri.dashboard');
    }
    // Kalau rolenya tidak dikenali, arahkan ke home
    return redirect('/');
}
    

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}