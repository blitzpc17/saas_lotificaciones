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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('development_id')->constrained()->onDelete('cascade');
            $table->string('block')->comment('Manzana');
            $table->string('number')->comment('Lote');
            $table->decimal('area', 8, 2)->comment('Área en m2');
            $table->decimal('price', 12, 2)->comment('Precio total');
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
