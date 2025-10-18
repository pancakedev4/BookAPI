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
        Schema::create('book_subscription_package', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('subscription_package_id');
            $table->timestamps();

            // Внешние ключи
            $table->foreign('book_id')
                ->references('id')
                ->on('books')
                ->onDelete('cascade');

            $table->foreign('subscription_package_id')
                ->references('id')
                ->on('subscription_packages')
                ->onDelete('cascade');

            // Уникальный индекс чтобы избежать дубликатов
            $table->unique(['book_id', 'subscription_package_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_subscription_package');
    }
};
