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
        Schema::create('over_much_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('main_project_id')->nullable();
            $table->string('unit_name');
            $table->integer('price_m');
            $table->integer('over_much');
            $table->integer('new_price_m');
            $table->decimal('unit_price', 32, 0);
            $table->decimal('new_unit_price', 32, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('over_much_units');
    }
};
