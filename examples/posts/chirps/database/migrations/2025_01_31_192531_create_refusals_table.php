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
        Schema::create('refusals', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('');
            $table->text('content')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('original_created_at')->nullable();
            $table->timestamp('original_updated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refusals');
    }
};
