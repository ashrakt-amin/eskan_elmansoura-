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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('sub_property_id')->nullable();
            $table->unsignedBigInteger('main_project_id')->nullable();
            $table->unsignedBigInteger('construction_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->string('space');
            $table->integer('price_m');
            $table->integer('unit_price')->nullable();
            $table->text('unitDescription')->nullable();
            $table->string('status')->default('خالية');
            $table->integer('customer_id')->default(0);
            $table->timestamps();



            // $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            // $table->foreign('sub_property_id')->references('id')->on('sub_properties')->onDelete('cascade');
            // $table->foreign('main_project_id')->references('id')->on('main_projects')->onDelete('cascade');
            // $table->foreign('construction_id')->references('id')->on('constructions')->onDelete('cascade');
            // $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            // $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
};
