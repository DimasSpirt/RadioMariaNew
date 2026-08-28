<?php

namespace App\Http\Middleware;

use App\Models\Banner;
use App\Models\SocialNetwork;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Cache;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [

            'global' => [
                'current_stream' => 'Радіо Марія (160 kbps)',
                'socialNetworks' => function () {
                    return SocialNetwork::published()->ordered()->get();
                },
                'banners' => Cache::remember('published_banners', 3600, function () {
                    return Banner::where('published', 1)->get()->keyBy('id');
                }),
            ],

            // Пробрасываем флеш-сообщения в Inertia
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],

//            'auth' => [
//                'user' => $request->user(),
//            ],
        ]);
    }
}