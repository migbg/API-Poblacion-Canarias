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
        Schema::create('municipios', function (Blueprint $table) {
            $table->string('codigo')->primary();
            $table->string('nombre');
            $table->string('gcd_isla');
            $table->foreign('gcd_isla')->references('gcd_isla')->on('islas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipios');
    }
};
