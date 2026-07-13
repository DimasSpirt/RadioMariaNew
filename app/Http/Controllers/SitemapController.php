<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->select('link')
            ->orderByDesc('pub_start')
            ->orderByDesc('id')
            ->limit(20)
            ->get();
        
        return response()
            ->view('sitemap', compact('posts'))
            ->header('Content-Type', 'text/xml; charset=utf-8');
    }
}