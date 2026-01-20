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
        Schema::create('islas', function (Blueprint $table) {
            $table->string('gcd_isla')->primary();
            $table->string('nombre');
            $table->string('gcd_provincia');
            $table->foreign('gcd_provincia')->references('gcd_provincia')->on('provincias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('islas');
    }
};
