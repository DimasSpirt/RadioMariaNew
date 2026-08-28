<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AudioProgram extends Model
{
    protected $table = 'audio_program';
    public $timestamps = false;

    public function posts()
    {
        // Указываем внешний ключ, так как он отличается от стандартного 'audio_program_id'
        return $this->hasMany(Post::class, 'audio_program');
    }
}