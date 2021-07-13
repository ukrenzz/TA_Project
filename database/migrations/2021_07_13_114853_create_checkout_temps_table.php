<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_temps', function (Blueprint $table) {
          $table->foreignId('product_id')->constrained('products');
          $table->foreignId('user_id')->constrained('users');
          $table->primary(['product_id', 'user_id']); // composite key
          $table->integer('quantity');
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
        Schema::dropIfExists('checkout_temps');
    }
}
