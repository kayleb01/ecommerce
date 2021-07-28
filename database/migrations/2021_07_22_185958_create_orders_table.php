<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned();
            $table->integer('quantity')->unsigned()->default(1);
            $table->double('total')->default(0);
            $table->double('price')->default(0);
            $table->double('shipping_id')->default(0);
            $table->string('order_number');
            $table->string('txn_ref')->nullable();
            $table->enum('payment_status', ['paid', 'unpaid']);
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
        Schema::dropIfExists('orders');
    }
}
