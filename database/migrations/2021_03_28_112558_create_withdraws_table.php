<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('party_id')->nullable();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('purpose_id');
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('api_key_id')->nullable();
            $table->string('location')->nullable();
            $table->integer('pos_receiving_id')->nullable();
            $table->integer('pos_expense_id')->nullable();
            $table->dateTime('withdraw_date');
            $table->string('note')->nullable();
            $table->string('voucher_number')->nullable();
            //voucher_number with settings prefix+this->id
            $table->string('money_receipt')->nullable();
            $table->double('total_amount', 23, 10);
            $table->enum('withdraw_type', ['menual','purchase', 'expense','transfer'])->defaut('menual');
            $table->enum('delete_status',['0','1'])->default('0');

            $table->foreign('party_id')
                    ->nullable()
                    ->references('id')
                    ->on('parties');
            $table->foreign('account_id')
                    ->references('id')
                    ->on('accounts');
            $table->foreign('purpose_id')
                    ->references('id')
                    ->on('purposes');
            $table->foreign('purchase_id')
                    ->nullable()
                    ->references('id')
                    ->on('purchases');
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
        Schema::dropIfExists('withdraws');
    }
}
