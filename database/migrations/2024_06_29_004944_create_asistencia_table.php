<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencia', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estudiante_id')->unsigned();
            $table->integer('grupo_id')->unsigned();
            $table->date('fecha')->nullable(false);
            $table->time('hora_entrada')->nullable(false);
            $table->foreign('estudiante_id')->references('id')->on('estudiante');
            $table->foreign('grupo_id')->references('id')->on('grupo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencia');
    }
};
