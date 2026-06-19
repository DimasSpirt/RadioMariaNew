<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index()
    {
        // Здесь берем данные конкретно для главной страницы (новости, сетка вещания)
        $posts = Post::published()->orderByDesc('pub_start')->paginate(12);

        return Inertia::render('Index', [
            'posts' => $posts
        ]);
    }
}