<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usuario_profesor', function (Blueprint $table) {
            // Añadir el campo descripcion
            $table->text('descripcion')->nullable()->after('media_calificacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuario_profesor', function (Blueprint $table) {
            // Eliminar el campo descripcion si se revierte la migración
            $table->dropColumn('descripcion');
        });
    }
};