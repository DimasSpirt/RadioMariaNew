<?php

namespace App\Http\Controllers;

use App\Models\Intension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IntensionController extends Controller
{
    public function store(Request $request)
    {
        // 1. Валидация входных данных, как в старом CI2
        $validated = $request->validate([
            'type' => 'required|numeric',
            'name' => 'required|string|max:255',
            'text' => 'required|string',
            'source' => 'nullable|string'
        ]);

        // 2. Логика тайм-аута (защита от спама)
        $timeLimit = 1; // 15 минут
        if (in_array($request->input('source'), ['youtube', 'viber'], true)) {
            $timeLimit = 1;
        }

        $lastPrayerTime = session('last_prayer_time');
        $currentTime = time();

        if ($lastPrayerTime) {
            $timePassed = $currentTime - $lastPrayerTime;

            if ($timePassed < $timeLimit) {
                $minutesLeft = ceil(($timeLimit - $timePassed) / 60);

                // Возвращаем ошибку, которую Inertia отобразит во Vue
                return back()->withErrors([
                    'message' => "Повідомлення не відправлено. Занадто часто! Будь ласка, зачекайте ще {$minutesLeft} хв."
                ]);
            }
        }

        // Очищаем данные от тегов (strip_tags), как было в старом коде
        $data = [
            'type' => $validated['type'],
            'name' => trim(strip_tags($validated['name'])),
            'text' => trim(strip_tags($validated['text'])),
            'viewed' => 0
        ];

        // 3. Сохраняем в базу данных
        Intension::create($data);

        // 4. Отправляем вебхук в черновики
        $this->sendToDrafts($data);

        // 5. Записываем время успешной отправки в сессию
        session(['last_prayer_time' => $currentTime]);

        // Возвращаемся обратно с сообщением об успехе
        return redirect()->back()->with('success', 'Ваше повідомлення успішно надіслано в ефір!');
    }

    /**
     * Отправка данных на внешний API Drafts
     */
    private function sendToDrafts(array $data)
    {
        $apiUrl = 'https://drafts.radiomaria.org.ua/api/intentions/webhook';
        $secretKey = 'radiomaria_to_drafts_secret';

        try {
            // Используем HTTP-фасад Laravel вместо старого cURL с тайм-аутом 3 сек
            $response = Http::timeout(3)
                ->withHeaders([
                    'X-Radio-Secret' => $secretKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($apiUrl, $data);

            if ($response->failed()) {
                Log::error('API Intentions HTTP Error.', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('API Intentions Request Error: ' . $e->getMessage());
        }
    }
}