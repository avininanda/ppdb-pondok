<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\PeriodePendaftaran;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
   public function create(): View|RedirectResponse
    {
        $pendaftaranDibuka = PeriodePendaftaran::where('is_aktif', true)->exists();

        if (!$pendaftaranDibuka) {
            return redirect()->route('login')
                ->with('error', 'Pendaftaran akun baru saat ini sedang ditutup.');
        }
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
            $pendaftaranDibuka = PeriodePendaftaran::where('is_aktif', true)->exists();

            if (!$pendaftaranDibuka) {
                return redirect()->route('login')
                    ->with('error', 'Pendaftaran akun baru saat ini sedang ditutup.');
            }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email:rfc,dns',  // ← tambah :rfc,dns
                'max:255',
                'unique:'.User::class
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

       return redirect()->route('santri.dashboard');
    }
}
