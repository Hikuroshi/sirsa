<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_usage_buckets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ai_api_key_id')->constrained()->cascadeOnDelete();
            $table->string('window');
            $table->timestamp('period_started_at');
            $table->unsignedInteger('requests')->default(0);
            $table->unsignedBigInteger('tokens')->default(0);
            $table->timestamps();

            $table->unique(['ai_api_key_id', 'window', 'period_started_at'], 'ai_usage_window_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_usage_buckets');
    }
};
