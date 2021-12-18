<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('api_key_id')->nullable();
            $table->string('location')->nullable();
            $table->integer('pos_receiving_item_id')->nullable();
            $table->decimal('purchase_quantity', 23, 10);
            $table->decimal('unit_price', 23, 10);
            $table->decimal('discount', 23, 10);
            $table->decimal('sub_total', 23, 10);
            $table->decimal('total', 23, 10);

            $table->foreign('purchase_id')
                    ->references('id')
                    ->on('purchases');
            $table->foreign('item_id')
                    ->references('id')
                    ->on('items');
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users');
            $table->foreign('api_key_id')
                    ->nullable()
                    ->references('id')
                    ->on('api_keys');
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
        Schema::dropIfExists('purchase_items');
    }
}
