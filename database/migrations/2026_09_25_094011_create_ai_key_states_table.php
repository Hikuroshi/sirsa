<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_key_states', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->timestamp('cooldown_until')->nullable();
            $table->unsignedInteger('failure_count')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_key_states');
    }
};
