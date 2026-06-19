<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'content';

    public const CREATED_AT = 'created';
    public const UPDATED_AT = 'modified';

    protected $guarded = ['id'];

    public function author()
    {
        return $this->belongsTo(AudioAuthor::class, 'audio_author');
    }

    public function program()
    {
        return $this->belongsTo(AudioProgram::class, 'audio_program');
    }

    public function presenter()
    {
        return $this->belongsTo(AudioPresenter::class, 'audio_presenter');
    }

    public function scopePublished($query)
    {
        return $query->where('published', 1)
            ->where('pub_start', '<=', now())
            ->where(function ($q) {
                $q->where('pub_end', '>=', now())
                    ->orWhereNull('pub_end');
            });
    }

    public function getSimilarPosts($limit = 5)
    {
        $query = self::published()
            ->where('id', '!=', $this->id)
            ->where('type', 0)
            ->orderByDesc('pub_start')
            ->orderByDesc('id')
            ->limit($limit);

        if ($this->audio) {
            $query->whereNotNull('audio')
                ->where(function ($q) {
                    $q->where('audio_program', $this->audio_program)
                        ->orWhere('audio_author', $this->audio_author)
                        ->orWhere('audio_presenter', $this->audio_presenter);
                });
        } else {
            $query->whereNull('audio');
        }

        return $query->get();
    }
}