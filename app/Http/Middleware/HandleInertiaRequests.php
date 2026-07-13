<?php

namespace App\Http\Middleware;

use App\Models\SocialNetwork;
use Illuminate\Http\Request;
use Inertia\Middleware;

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
            ],

//            'auth' => [
//                'user' => $request->user(),
//            ],
        ]);
    }
}