<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePurposesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purposes', function (Blueprint $table) {
            $table->id();
			$table->string('name');
            $table->unsignedBigInteger('purpose_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('api_key_id')->nullable();
            $table->integer('pos_purpose_id')->nullable();
            $table->enum('purpose_type', ['income','expanse']);
            $table->enum('delete_status',['0','1'])->default('0');
            $table->foreign('purpose_id')
                    ->nullable()
                    ->references('id')
                    ->on('purposes');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('purposes');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
