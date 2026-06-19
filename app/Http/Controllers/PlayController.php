<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PlayController extends Controller
{
    /**
     * Страница с выбором стримов
     */
    public function index()
    {
        // Просто отдаем во Vue массив стримов прямо из нашего конфига
        return Inertia::render('Play/Index', [
            'streams' => config('radio.streams')
        ]);
    }

    /**
     * Скачивание аудиофайла
     */
    public function download($id)
    {
        $post = Post::where('id', $id)->where('published', 1)->firstOrFail();

        if (!$post->audio) {
            abort(404, 'Аудіофайл не знайдено');
        }

        // Атомарно увеличиваем счетчик скачиваний
        $post->increment('audio_downloaded');

        // Формируем красивое имя файла транслитом
        $baseName = 'Radio-Maria_' . $post->audio_date . '_' . $post->title . '_' . $post->audio_theme;
        $filename = Str::slug($baseName, '-') . '.mp3';

        $filepath = public_path('audio/content/' . $post->audio);

        if (!file_exists($filepath)) {
            abort(404, 'Файл відсутній на сервері');
        }

        return response()->download($filepath, $filename);
    }

    /**
     * Трекинг прослушиваний (для AJAX)
     */
    public function track(Request $request, $id)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            abort(404);
        }

        Post::where('id', $id)->increment('audio_played');

        return response()->json(['success' => true]);
    }
}