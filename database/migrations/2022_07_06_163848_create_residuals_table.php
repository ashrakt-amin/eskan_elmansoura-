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
        Schema::create('residuals', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_id');
            $table->integer('customer_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('installment_id')->nullable();
            $table->decimal('unit_price', 32);
            $table->decimal('all_payments', 32);
            $table->decimal('all_recoveries', 32)->default(0);
            $table->decimal('all_residuals', 32);
            $table->tinyInteger('cancellation_code')->default(0);
            $table->timestamps();

            // $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            // $table->foreign('installment_id')->references('id')->on('installments')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residuals');
    }
};
