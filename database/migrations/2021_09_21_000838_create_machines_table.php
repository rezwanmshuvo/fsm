<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_key_id')->nullable();
            $table->unsignedBigInteger('tank_id');
            $table->string('name');
            $table->string('model')->nullable();
            $table->string('no_of_nozzle')->nullable();
            $table->string('serial_no')->nullable();
            $table->enum('delete_status',['0','1'])->default('0');
            $table->timestamps();

            $table->foreign('api_key_id')
                    ->nullable()
                    ->references('id')
                    ->on('api_keys');
            $table->foreign('tank_id')
                    ->references('id')
                    ->on('tanks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machines');
    }
}
