<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaToClasesTable extends Migration
{
    public $withinTransaction = false;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clase', function (Blueprint $table) {
            $table->date('fecha')->default('2026-03-01');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clase', function (Blueprint $table) {
            $table->dropColumn('fecha');
        });
    }
}
