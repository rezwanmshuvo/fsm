<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('item_category_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('api_key_id')->nullable();
            $table->string('location')->nullable();
            $table->integer('pos_item_id')->nullable();
            $table->double('costing_price', 23, 10);
            $table->double('selling_price', 23, 10);
            $table->double('average_costing_price', 23, 10);
            $table->double('opening_stock', 23, 10);
            $table->double('current_stock', 23, 10)->default('0');
            $table->enum('delete_status',['0','1'])->default('0');
            $table->foreign('item_category_id')
                    ->references('id')
                    ->on('item_categories');
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
        Schema::dropIfExists('items');
    }
}
