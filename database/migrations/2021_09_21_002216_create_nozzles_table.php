<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNozzlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nozzles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_key_id')->nullable();
            $table->unsignedBigInteger('machine_id');
            $table->unsignedBigInteger('item_id');
            $table->string('name');
            $table->double('start_reading', 23, 10);
            $table->double('current_reading', 23, 10);
            $table->enum('delete_status',['0','1'])->default('0');
            $table->timestamps();

            $table->foreign('api_key_id')
                    ->nullable()
                    ->references('id')
                    ->on('api_keys');
            $table->foreign('machine_id')
                    ->references('id')
                    ->on('machines');
            $table->foreign('item_id')
                    ->references('id')
                    ->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nozzles');
    }
}
