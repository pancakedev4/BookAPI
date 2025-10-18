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
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_period_id');
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->integer('discount_in_partner_store')->default(0);
            $table->timestamps();

            $table->foreign('subscription_period_id')
                ->references('id')
                ->on('subscription_periods')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_packages');
    }
};
