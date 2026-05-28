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
        Schema::create('mantenimiento', function (Blueprint $table) {
            $table->id();

            $table->integer('mes');

            $table->integer('año');

            $table->foreignId('id_depa')
                ->constrained('departamentos');

            $table->boolean('completado')->default(false);

            $table->decimal('monto', 10, 2);

            $table->foreignId('id_pago')
                ->nullable()
                ->constrained('pagos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento');
    }
};
