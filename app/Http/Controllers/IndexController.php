<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\AudioAuthor;
use App\Models\AudioPresenter;
use App\Models\AudioProgram;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index()
    {
        // 1. Верхний левый блок («Рекомендуем» / Выбор редакции)
        // Ищем самый просматриваемый аудио-пост за последние 7 дней
        $featuredPost = Post::published()
            ->whereNotNull('audio')
            ->where('pub_start', '>=', now()->subDays(7))
            ->with(['author', 'program', 'presenter'])
            ->orderByDesc('hits')
            ->first();

        // Если за неделю ничего нет, берем самый популярный в принципе, чтобы не ломать верстку
        if (!$featuredPost) {
            $featuredPost = Post::published()
                ->whereNotNull('audio')
                ->with(['author', 'program', 'presenter'])
                ->orderByDesc('hits')
                ->first();
        }

        // 2. Верхний правый блок (Карусель свежих подкастов из разных программ)
        // Берем пачку свежих постов и средствами коллекций Laravel оставляем по одному на программу
        $featuredHighlights = Post::published()
            ->whereNotNull('audio_program')
            ->with(['author', 'program', 'presenter'])
            ->orderByDesc('pub_start')
            ->limit(30) // Берем 30 свежих с запасом
            ->get()
            ->unique('audio_program') // Оставляем только первый встретившийся пост для каждой программы
            ->take(3) // Нам нужно 3 блока
            ->values(); // Сбрасываем ключи коллекции, чтобы Vue получил чистый массив, а не объект с дырками в индексах

        // 3. Нижний левый блок («Цикл программ» / Плейлист)
        // Находим последнюю опубликованную программу (сразу подгружаем связь program, чтобы не делать find() дальше)
        $latestSeriesPost = Post::published()
            ->whereNotNull('audio_program')
            ->with('program')
            ->orderByDesc('pub_start')
            ->first();

        $programSeries = null;
        if ($latestSeriesPost && $latestSeriesPost->program) {
            $programSeries = [
                'program' => $latestSeriesPost->program,
                'episodes' => Post::published()
                    ->where('audio_program', $latestSeriesPost->audio_program)
                    ->with(['author', 'presenter'])
                    ->orderByDesc('pub_start')
                    ->limit(5)
                    ->get()
            ];
        }

        // --- Данные для фильтров и общая статистика ---
        $filters = [
            'authors' => AudioAuthor::select('id', 'name')->orderBy('name')->get(),
            'presenters' => AudioPresenter::select('id', 'name')->orderBy('name')->get(),
            'programs' => AudioProgram::select('id', 'name')->orderBy('name')->get(),
        ];

        // Самые популярные программы
        $popularPrograms = AudioProgram::withCount(['posts' => function ($query) {
            $query->published();
        }])
            ->orderByDesc('posts_count')
            ->limit(8)
            ->get();

        // Основная лента постов
        $posts = Post::with(['author', 'program', 'presenter'])
            ->published()
            ->orderByDesc('pub_start')
            ->paginate(12);

        return Inertia::render('Index', [
            'featuredPost' => $featuredPost,
            'featuredHighlights' => $featuredHighlights,
            'programSeries' => $programSeries,
            'filters' => $filters,
            'popularPrograms' => $popularPrograms,
            'totalPosts' => Post::published()->count(),
            'posts' => $posts,
        ]);
    }
}