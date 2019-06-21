<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->integer('type');
            $table->integer('user_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('from')->nullable();
            $table->integer('to')->nullable();
            $table->integer('status')->nullable();
            $table->float('amount', 14, 2)->nullable();
            $table->dateTime('timestamp')->useCurrent();
            $table->string('attachment')->nullable();
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
