<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    public function show($fullSlug)
    {
        // 1. Достаем ID
        $parts = explode('-', $fullSlug);
        $id = (int) array_pop($parts);

        // 2. Ищем пост и ЖАДНО грузим связи (Eager Loading), чтобы избежать проблемы N+1 запросов
        $post = Post::published()
            ->with(['author', 'program', 'presenter'])
            ->findOrFail($id);

        // 3. Фиксируем просмотр (вынесено в приватный метод ниже)
        $this->recordHit($post);

        // 4. Достаем похожие посты через метод модели
        $similar = $post->getSimilarPosts(5);

        // 5. Рендерим
        return Inertia::render('Post/Show', [
            'post' => $post,
            'similar' => $similar
        ]);
    }

    /**
     * Изолированная логика учета уникальных просмотров
     */
    private function recordHit(Post $post): void
    {
        $recentArray = session()->get('recent_array', []);

        if (!in_array($post->id, $recentArray)) {
            $recentArray[] = $post->id;
            session()->put('recent_array', $recentArray);

            $post->timestamps = false;
            $post->increment('hits');
        }
    }
}