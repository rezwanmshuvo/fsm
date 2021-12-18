<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_key_id')->nullable();
            $table->string('name');
            $table->time('start_time', $precision = 0);
            $table->time('end_time', $precision = 0);
            $table->enum('delete_status',['0','1'])->default('0');
            $table->timestamps();

            $table->foreign('api_key_id')
                    ->nullable()
                    ->references('id')
                    ->on('api_keys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
}
