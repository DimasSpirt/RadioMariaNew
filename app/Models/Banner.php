<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    public const GOOGLE_PLAY = 3;
    public const APP_STORE = 4;

    protected $fillable = [
        'name',
        'code',
        'image',
        'image_class',
        'text',
        'url',
        'new_tab',
        'published',
        'position',
    ];

    protected $casts = [
        'new_tab' => 'boolean',
        'published' => 'integer',
    ];
}