<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Получить расписание на 7 дней (сегодня + 6 дней)
     * Данные автоматически группируются по датам
     */
    public function getWeek(Request $request)
    {
        $startDate = now()->format('Y-m-d');
        $endDate = now()->addDays(6)->format('Y-m-d');

        // Кэшируем этот жирный запрос на 1 час.
        // Ключ кэша меняется каждый день (schedule_week_2026-07-01)
        $schedule = Cache::remember('schedule_week_' . $startDate, 3600, function () use ($startDate, $endDate) {

            // Запрашиваем из базы одним запросом
            $data = Schedule::with('program')
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('date', 'asc')
                ->orderBy('ts', 'asc')
                ->get();

            return $data->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            });
        });

        return response()->json($schedule);
    }
}