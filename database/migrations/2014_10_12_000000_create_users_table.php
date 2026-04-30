<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('titulo', 60)->nullable();
            $table->string('metadescription', 160)->nullable();
            $table->string('descripcion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('activo')->default(1);
            $table->integer('rol')->default('0');
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('whatsapp')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
