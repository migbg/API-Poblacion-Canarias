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
        Schema::create('poblacions', function (Blueprint $table) {
            $table->id();
            $table->integer('periodo');
            $table->enum('sexo', ['F', 'M']);
            $table->integer('edad');
            $table->integer('cantidad');
            $table->string('codigo_municipio');
            $table->foreign('codigo_municipio')->references('codigo')->on('municipios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poblacions');
    }
};
