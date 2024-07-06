<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('estudiante', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 255)->nullable(false);
            $table->string('apellido', 255)->nullable(false);
            $table->string('email', 255)->unique()->nullable(false);
            $table->string('pin', 255)->nullable(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('estudiante');
    }
};