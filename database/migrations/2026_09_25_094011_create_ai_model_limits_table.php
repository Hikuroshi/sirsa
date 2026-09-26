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
        Schema::create('ai_model_limits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('provider', 50);
            $table->string('model', 150);
            $table->unsignedInteger('rpm');
            $table->unsignedInteger('rpd');
            $table->unsignedBigInteger('tpm');
            $table->timestamps();

            $table->unique(['provider', 'model']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_model_limits');
    }
};
