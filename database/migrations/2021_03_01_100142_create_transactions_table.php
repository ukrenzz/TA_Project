<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('note', 100)->default("-");
            $table->foreignId('user_id')->constrained('users');
            $table->smallInteger('ppn')->default("5");
            $table->string('status', 50);
            $table->bigInteger('discount')->default("0");
            $table->bigInteger('shipping_cost');
            $table->string('shipping_method', 100);
            $table->string('payment_method', 100);
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
        Schema::dropIfExists('transactions');
    }
}
