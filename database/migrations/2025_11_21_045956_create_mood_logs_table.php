<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mood_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('telegram_user_id')->constrained('telegram_users')->onDelete('cascade');
            $table->tinyInteger('rating'); // 1–5
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mood_logs');
    }
};
