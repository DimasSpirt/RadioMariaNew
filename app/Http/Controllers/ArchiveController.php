<?php

namespace App\Http\Controllers;

use App\Models\Post; // Твоя модель записи/подкаста
use App\Models\AudioProgram;
use App\Models\AudioAuthor; // Гость
use App\Models\AudioPresenter; // Ведучий
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        // 1. Собираем запрос с жадной загрузкой связей
        $query = Post::query()
            ->with(['program', 'author', 'presenter'])
            ->orderBy('pub_start', 'desc');

        // 2. Применяем фильтры
        if ($request->filled('program')) {
            $query->where('audio_program', $request->program);
        }
        if ($request->filled('author')) {
            $query->where('audio_author', $request->author);
        }
        if ($request->filled('presenter')) {
            $query->where('audio_presenter', $request->presenter);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('pub_start', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('pub_start', '<=', $request->date_to);
        }
        if ($request->filled('search')) {
            // Поиск по названию (если нужно, можно расширить на другие поля)
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 3. Пагинация с сохранением GET-параметров в ссылках
        $posts = $query->paginate(15)->withQueryString();

        // 4. Данные для селектов
        $filters = [
            'programs' => AudioProgram::orderBy('name')->get(['id', 'name']),
            'authors' => AudioAuthor::orderBy('name')->get(['id', 'name']),
            'presenters' => AudioPresenter::orderBy('name')->get(['id', 'name']),
        ];

        return Inertia::render('Archive/Index', [
            'posts' => $posts,
            'filters' => $filters,
            // Прокидываем текущие параметры обратно во вьюху, чтобы заполнить инпуты
            'queryParams' => $request->only([
                'program', 'author', 'presenter', 'date_from', 'date_to', 'search'
            ]),
        ]);
    }
}