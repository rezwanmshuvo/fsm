<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->dateTime('purchase_date');
            $table->unsignedBigInteger('party_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('api_key_id')->nullable();
            $table->string('location')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->integer('pos_receiving_id')->nullable();
            $table->decimal('total_purchase_quantity', 23, 10);
            $table->decimal('total_discount', 23, 10)->default('0');
            $table->decimal('sub_total_amount', 23, 10);
            $table->decimal('total_amount', 23, 10);
            $table->enum('delete_status',['0','1'])->default('0');

            $table->foreign('party_id')
                    ->nullable()
                    ->references('id')
                    ->on('parties');
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
        Schema::dropIfExists('purchases');
    }
}
