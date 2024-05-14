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
        Schema::create('compromissos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_consultor')->nullable(false);
            $table->foreign('id_consultor')->references('id')->on('consultores');
            $table->date('data')->nullable(false);
            $table->time('hora_inicio')->nullable(false);
            $table->time('hora_fim')->nullable(false);
            $table->time('intervalo')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compromissos');
    }
};
