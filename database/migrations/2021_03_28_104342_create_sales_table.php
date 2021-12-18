<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->dateTime('sale_date');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('api_key_id')->nullable();
            $table->string('location')->nullable();
            $table->integer('pos_sale_id')->nullable();
            $table->decimal('total_sale_quantity', 23, 10);
            $table->decimal('total_discount', 23, 10)->default('0');
            $table->decimal('sub_total_amount', 23, 10);
            $table->decimal('total_amount', 23, 10);
            $table->enum('delete_status',['0','1'])->default('0');
            $table->enum('hold_status',['0','1'])->default('0');

            $table->foreign('customer_id')
                    ->nullable()
                    ->references('id')
                    ->on('customers');
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
        Schema::dropIfExists('sales');
    }
}
