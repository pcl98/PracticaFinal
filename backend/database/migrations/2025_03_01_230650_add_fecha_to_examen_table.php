<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaToExamenTable extends Migration
{
    public $withinTransaction = false;

    /**
     * Ejecutar la migración.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examen', function (Blueprint $table) {
            // Agregar la columna 'fecha' de tipo date
            $table->date('fecha')->default('2026-03-01');  // Aquí se establece el valor por defecto
        });
    }

    /**
     * Revertir la migración.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('examen', function (Blueprint $table) {
            // Eliminar la columna 'fecha'
            $table->dropColumn('fecha');
        });
    }
}
