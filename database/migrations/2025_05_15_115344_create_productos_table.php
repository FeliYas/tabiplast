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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('orden')->nullable();
            $table->string('titulo')->nullable();
            $table->string('tituloen')->nullable();
            $table->string('tituloport')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->mediumText('descripcionen')->nullable();
            $table->mediumText('descripcionport')->nullable();
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->onDelete('cascade');
            $table->string('ficha')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
