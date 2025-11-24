<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $fillable = [
       'telegram_id',
        'full_name',
        'age',
        'gender',
        'auth_step',
        'status',
        'username',
        'first_name'
        ];
}
