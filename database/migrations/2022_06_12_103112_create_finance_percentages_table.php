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
        Schema::create('finance_percentages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('payment_kind_id')->nullable();
            $table->decimal('payment_kind_percentage')->nullable();
            $table->double('payment_kind_value')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();




            // $table->foreign('finance_id')->references('id')->on('finances')->onDelete('cascade');
            // $table->foreign('payment_kind_id')->references('id')->on('payment_kinds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_percentages');
    }
};
