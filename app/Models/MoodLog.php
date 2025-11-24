<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodLog extends Model
{
    protected $table = [
        'telegram_user_id',
        'rating',
    ];
}
