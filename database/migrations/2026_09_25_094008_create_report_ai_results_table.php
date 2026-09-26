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
        Schema::create('report_ai_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('report_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignUuid('category_id')->nullable()->constrained()->nullOnDelete();
            $table->uuid('ai_api_key_id')->nullable();
            $table->text('refined_description');
            $table->string('priority');
            $table->text('reason')->nullable();
            $table->string('provider');
            $table->string('model');
            $table->unsignedInteger('input_tokens')->default(0);
            $table->unsignedInteger('output_tokens')->default(0);
            $table->json('response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_ai_results');
    }
};
