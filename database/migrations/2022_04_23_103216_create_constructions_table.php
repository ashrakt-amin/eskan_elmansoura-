<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constructions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('main_project_id')->nullable();
            $table->integer('levels_count');
            $table->integer('level_units');
            $table->integer('total_units');
            $table->integer('coast')->nullable();
            $table->timestamps();

            // $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            // $table->foreign('main_project_id')->references('id')->on('main_projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('constructions');
    }
};
