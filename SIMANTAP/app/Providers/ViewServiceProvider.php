<?php

namespace App\Providers;

use App\Models\NotifikasiModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.header', function ($view) {
            $user = Auth::user();
            if ($user) {
                $notifikasis = NotifikasiModel::where('user_id', $user->user_id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $unreadCount = $notifikasis->where('is_read', false)->count();
            } else {
                $notifikasis = collect();
                $unreadCount = 0;
            }
            $view->with(compact('notifikasis', 'unreadCount'));
        });
    }
}
