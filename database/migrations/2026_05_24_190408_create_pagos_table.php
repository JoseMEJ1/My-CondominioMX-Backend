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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_depa')
                ->constrained('departamentos');

            $table->decimal('monto', 10, 2);

            $table->foreignId('id_tipo')
                ->constrained('tipos_pago');

            $table->date('fecha');

            $table->foreignId('id_motivo')
                ->constrained('motivos');

            $table->string('descripcion')->nullable();

            $table->string('comprobante')->nullable();

            $table->boolean('efectuado')->default(false);

            $table->foreignId('id_reporte')
                ->nullable()
                ->constrained('reportes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
