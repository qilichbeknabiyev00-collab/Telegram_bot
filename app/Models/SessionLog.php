<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionLog extends Model
{
    protected $table = [
        'telegram_user_id',
        'test_type',
        'answers',
        'score',
        'status',
    ];
}
