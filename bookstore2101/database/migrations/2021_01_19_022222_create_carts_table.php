<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 30);
            $table->tinyInteger('quantity')->unsigned();
            $table->integer('subtotal')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('book_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')
                ->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
