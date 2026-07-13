<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    // Привязываем красивую модель к легаси-таблице
    protected $table = 'audio_calendar';

    // Отключаем timestamps, так как в старой базе нет created_at и updated_at
    public $timestamps = false;

    protected $fillable = [
        'date',
        'time',
        'program_id',
        'ts' // UNIX-timestamp начала передачи
    ];

    protected $casts = [
        'date' => 'date',
        'ts' => 'integer',
    ];

    /**
     * Отношение к передаче (чтобы получать название и автора)
     */
    public function program()
    {
        return $this->belongsTo(AudioProgram::class, 'program_id');
    }
}