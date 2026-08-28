<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'static_content';

    protected $fillable = [
        'name',
        'link',
        'text',
        'published',
        'title',
        'description',
        'keywords',
        'type',
        'color',
    ];

    public $timestamps = false;

    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }
}