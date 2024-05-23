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
        Schema::create('activities', function (Blueprint $table) {
            $table->id("idactivity");
            $table->timestamp('start');
            $table->timestamp('finish')->nullable();
            $table->string('detailActivity');
            $table->unsignedBigInteger('proyect_idproyect');
            $table->foreign('proyect_idproyect')->references('idproyect')->on('proyects')->onDelete('cascade');
            $table->unsignedBigInteger('task_idtask');
            $table->foreign('task_idtask')->references('idtask')->on('tasks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
