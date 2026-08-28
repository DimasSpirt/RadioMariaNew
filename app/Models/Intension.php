<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intension extends Model
{
    const UPDATED_AT = null;
    protected $fillable = [
        'type',
        'name',
        'text',
        'viewed' // По умолчанию в БД должно быть 0
    ];
}