<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand', 50);
            $table->integer('stock');
            $table->bigInteger('price');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('unit', 20);
            $table->text('description');
            $table->text('color');
            $table->string('status', 25);
            $table->bigInteger('discount')->nullable()->default(0);
            $table->foreignId('add_by_user_id')->constrained('users');
            $table->timestamps();
            // $table->foreign('category_id')->reference('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
