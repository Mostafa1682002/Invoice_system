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
        Schema::create('invoice__details', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->string('product');
            $table->string('section');
            $table->string('status', 50);
            $table->integer('value_status');
            $table->text('notes')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice__details');
    }
};
