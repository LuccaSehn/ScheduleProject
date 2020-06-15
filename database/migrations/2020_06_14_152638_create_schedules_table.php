<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clients_id')->nullable();
            $table->foreign('clients_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('commercial_room_id')->nullable();
            $table->foreign('commercial_room_id')->references('id')->on('commercial_room')->onDelete('cascade');
            $table->string('observation');
            $table->date('schedule_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
