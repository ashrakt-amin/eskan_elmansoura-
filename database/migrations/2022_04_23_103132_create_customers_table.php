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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mid_name');
            $table->string('last_name');
            $table->tinyInteger('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone', '11')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->bigInteger('national_id')->nullable()->unique();
            $table->text('additional_info')->nullable();

            $table->unsignedBigInteger('privilege_id')->nullable();

            // $table->foreign('privilege_id')->references('id')->on('privileges')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('customers');
    }
};
