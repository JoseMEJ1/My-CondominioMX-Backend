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
        Schema::create('per_dep', function (Blueprint $table) {
            $table->foreignId('id_persona')
                ->constrained('personas')
                ->onDelete('cascade');

            $table->foreignId('id_depa')
                ->constrained('departamentos')
                ->onDelete('cascade');

            $table->foreignId('id_rol')
                ->constrained('roles')
                ->onDelete('cascade');

            $table->boolean('residente')->default(true);
            $table->string('codigo');

            $table->primary(['id_persona', 'id_depa']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('per_dep');
    }
};
