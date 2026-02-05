<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_page_id')->constrained()->onDelete('cascade');
            $table->string('audit_type');
            $table->json('audit_data');
            $table->decimal('score', 5, 2);
            $table->text('recommendations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_audit_logs');
    }
};