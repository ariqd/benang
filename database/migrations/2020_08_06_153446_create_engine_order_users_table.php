<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngineOrderUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_engines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('process_id');
            $table->unsignedBigInteger('engine_id');
            $table->float('qty');
            $table->timestamps();

            $table->foreign('process_id')->references('id')->on('process');
            $table->foreign('engine_id')->references('id')->on('engines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('engine_order_users');
    }
}
