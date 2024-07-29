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
        Schema::create('user_proyect_activities', function (Blueprint $table) {
            $table->id('UserProyectActivity_id');
            $table->timestamps();
            $table->unsignedBigInteger('UserProyect_iduser');
            $table->unsignedBigInteger('activities_idactivity');
            $table->foreign('UserProyect_iduser')->references('user_id')->on('user_has_proyects')->onDelete('cascade');
            $table->foreign('activities_idactivity')->references('idactivity')->on('activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_proyect_activities');
    }
};
