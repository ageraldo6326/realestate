<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiasPropiedadContactosToInmobiliariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inmobiliarias', function (Blueprint $table) {
            $table->unsignedInteger('dias_propiedad_contactos')->default(90)->after('aprobacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inmobiliarias', function (Blueprint $table) {
            $table->dropColumn('dias_propiedad_contactos');
        });
    }
}
