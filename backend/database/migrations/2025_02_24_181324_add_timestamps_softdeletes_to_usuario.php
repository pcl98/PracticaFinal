<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->timestamps(); // Agrega created_at y updated_at
            $table->softDeletes(); // Agrega deleted_at para SoftDeletes
        });
    }

    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropTimestamps(); // Elimina created_at y updated_at
            $table->dropSoftDeletes(); // Elimina deleted_at
        });
    }
};
