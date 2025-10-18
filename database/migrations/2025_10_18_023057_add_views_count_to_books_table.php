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
        Schema::table('books', function (Blueprint $table) {
            $table->integer('views_count')->default(0)->after('language');
            $table->boolean('is_featured')->default(false)->after('views_count');

            // Добавляем индексы для оптимизации сортировки
            $table->index('views_count');
            $table->index('is_featured');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'is_featured']);
            $table->dropIndex(['views_count']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['created_at']);
        });
    }
};
