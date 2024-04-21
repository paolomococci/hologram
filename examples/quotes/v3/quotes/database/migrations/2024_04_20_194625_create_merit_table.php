<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'quotesdb';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('merit', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_main_author')->nullable();
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('author_id');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merit');
    }
};
