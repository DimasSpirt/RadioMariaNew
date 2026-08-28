<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;

class PageController extends Controller
{
    public function show($slug)
    {
        $decodedSlug = urldecode($slug);

        $page = Page::published()
            ->where('link', $decodedSlug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $allPages = Page::published()
            ->select('id', 'name', 'link')
            ->get();

        return Inertia::render('Pages/Show', [
            'page' => $page,
            'allPages' => $allPages,
        ]);
    }
}