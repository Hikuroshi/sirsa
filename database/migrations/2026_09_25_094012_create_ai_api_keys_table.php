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
        Schema::create('ai_api_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignUuid('ai_model_limit_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->text('secret');
            $table->string('suffix', 8);
            $table->unsignedSmallInteger('priority')->default(100);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('rpm')->nullable();
            $table->unsignedInteger('rpd')->nullable();
            $table->unsignedBigInteger('tpm')->nullable();
            $table->timestamp('cooldown_until')->nullable();
            $table->unsignedInteger('failure_count')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'ai_model_limit_id', 'is_active', 'priority'], 'ai_keys_selection_index');
        });

        Schema::table('report_ai_results', function (Blueprint $table) {
            $table->foreign('ai_api_key_id')->references('id')->on('ai_api_keys')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_ai_results', function (Blueprint $table) {
            $table->dropForeign(['ai_api_key_id']);
        });

        Schema::dropIfExists('ai_api_keys');
    }
};
