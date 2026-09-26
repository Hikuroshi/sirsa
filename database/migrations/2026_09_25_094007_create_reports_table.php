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
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('reporter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tracking_code', 32)->unique();
            $table->string('reporter_name');
            $table->string('reporter_contact')->nullable();
            $table->text('original_description');
            $table->text('description');
            $table->string('priority')->default('medium');
            $table->string('status')->default('accepted');
            $table->string('ai_status')->default('disabled');
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('ai_cancelled_at')->nullable();
            $table->timestamp('ai_processed_at')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'status', 'created_at']);
            $table->index(['reporter_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
