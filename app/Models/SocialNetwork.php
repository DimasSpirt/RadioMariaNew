<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    // Указываем легаси-таблицу
    protected $table = 'social_networks';

    // Переопределяем стандартные таймстемпы Laravel на те, что в базе
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fillable = [
        'title',
        'link',
        'image', // Оставляем на случай, если легаси-админка требует это поле при сохранении
        'published',
        'ordering',
        'approved',
        'user_id'
    ];

    /**
     * Скоуп: только опубликованные
     */
    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    /**
     * Скоуп: сортировка по ordering
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('ordering', 'asc');
    }
}