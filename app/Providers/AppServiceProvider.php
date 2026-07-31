<?php

namespace App\Providers;

use App\Models\Pendaftaran;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; 

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useBootstrapFive();
        
        // Share data pendaftaran ke semua view yang pakai layout dashboard
        // Ini jauh lebih rapi daripada query di blade
        View::composer('layouts.dashboard', function ($view) {
            if (auth()->check() && auth()->user()->isCalonSantri()) {
                $pendaftaranSantri = Pendaftaran::where('user_id', auth()->id())->first();
                $view->with('pendaftaranSantri', $pendaftaranSantri);
            }
        });

       
    }
}