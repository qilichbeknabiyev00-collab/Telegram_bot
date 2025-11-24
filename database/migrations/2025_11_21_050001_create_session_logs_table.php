<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('session_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('telegram_user_id')->constrained('telegram_users')->onDelete('cascade');
            $table->string('test_type'); // stress, motivation, neutral
            $table->json('answers')->nullable();
            $table->integer('score')->nullable();
            $table->string('status')->default('in_progress'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('session_logs');
    }
};

