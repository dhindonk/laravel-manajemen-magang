<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Absen;
use App\Models\SuratBalasan;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer(['layouts.admin'], function ($view) {
            $pendingUsers = User::where('is_verified', false)
                               ->where('role', 'mahasiswa')
                               ->count();
                               
            $pendingSurat = User::where('is_verified', true)
                               ->where('role', 'mahasiswa')
                               ->whereDoesntHave('suratBalasan')
                               ->count();
                               
            $pendingAbsen = Absen::where('is_verified', false)->count();
            
            $view->with(compact('pendingUsers', 'pendingSurat', 'pendingAbsen'));
        });
    }

    public function register()
    {
        //
    }
} 