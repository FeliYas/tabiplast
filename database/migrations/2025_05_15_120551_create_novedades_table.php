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
        Schema::create('novedades', function (Blueprint $table) {
            $table->id();
            $table->string('orden')->nullable();
            $table->string('path')->nullable();
            $table->string('epigrafe')->nullable();
            $table->string('titulo')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->string('epigrafeen')->nullable();
            $table->string('tituloen')->nullable();
            $table->mediumText('descripcionen')->nullable();
            $table->string('epigrafeport')->nullable();
            $table->string('tituloport')->nullable();
            $table->mediumText('descripcionport')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novedades');
    }
};
