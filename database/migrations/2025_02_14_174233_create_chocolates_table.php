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
        Schema::create('chocolates', function (Blueprint $table) {
            $table->id();
	    $table->string('nombre', 255);
	    $table->string('marca', 255);
            $table->decimal('porcentaje',10,2);
            $table->unsignedBigInteger('codigotipo')->nullable();
            $table->timestamps();
	    $table->foreign('codigotipo')->references('id')->on('tipos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chocolates');
    }
};
