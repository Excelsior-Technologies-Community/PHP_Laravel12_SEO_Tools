<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_url')->unique();
            $table->string('page_title');
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->text('canonical_url')->nullable();
            $table->json('json_ld')->nullable();
            $table->text('h1_tag')->nullable();
            $table->text('h2_tags')->nullable();
            $table->integer('word_count')->default(0);
            $table->integer('image_count')->default(0);
            $table->integer('internal_links')->default(0);
            $table->integer('external_links')->default(0);
            $table->decimal('performance_score', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};