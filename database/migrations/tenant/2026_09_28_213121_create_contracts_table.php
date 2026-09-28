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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_id')->constrained()->onDelete('restrict');
            $table->foreignId('customer_id')->constrained()->onDelete('restrict');
            $table->date('date');
            $table->decimal('total_amount', 12, 2);
            $table->decimal('down_payment', 12, 2)->comment('Enganche');
            $table->integer('financing_term_months')->default(0);
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
