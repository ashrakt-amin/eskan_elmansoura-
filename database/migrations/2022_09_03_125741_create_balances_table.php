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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_project_id');
            $table->decimal('starting_balance', 32);
            $table->decimal('excepted_balance', 32);
            $table->decimal('current_balance', 32)->nullable(); // updated row (allways)
            $table->decimal('actual_balance', 32)->nullable();
            $table->tinyInteger('balance_code');
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
        Schema::dropIfExists('balances');
    }
};
