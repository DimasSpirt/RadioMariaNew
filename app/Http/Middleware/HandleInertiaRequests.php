<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            // Глобальные переменные, доступные в любом Vue-компоненте
            'global' => [
                'current_stream' => 'Радіо Марія (160 kbps)',
                'facebook_url' => 'https://www.facebook.com/radiomariaukraine/',
            ],
            // Данные авторизованного пользователя (если есть)
            'auth' => [
                'user' => $request->user(),
            ],
        ]);
    }
}