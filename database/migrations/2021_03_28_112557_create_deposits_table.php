<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('purpose_id');
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('api_key_id')->nullable();
            $table->string('location')->nullable();
            $table->integer('pos_sale_id')->nullable();
            $table->dateTime('deposit_date');
            $table->string('note')->nullable();
            $table->string('voucher_number')->nullable();
            //voucher_number with settings prefix+this->id
            $table->string('money_receipt')->nullable();
            $table->double('total_amount', 23, 10);
            $table->enum('deposit_type', ['menual','sales','transfer'])->defaut('menual');
            $table->enum('delete_status',['0','1'])->default('0');

            $table->foreign('customer_id')
                    ->nullable()
                    ->references('id')
                    ->on('customers');
            $table->foreign('account_id')
                    ->references('id')
                    ->on('accounts');
            $table->foreign('purpose_id')
                    ->references('id')
                    ->on('purposes');
            $table->foreign('sale_id')
                    ->nullable()
                    ->references('id')
                    ->on('sales');
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
        Schema::dropIfExists('deposits');
    }
}
