<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_queue_history_calls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('room_queue_id')->nullable();
            $table->string('room_code')->nullable(false);
            $table->string('number_queue')->nullable();
            $table->string('number_code')->nullable();

            $table->integer('process_time_queue_room')->nullable();
            $table->timestamp('called_at')->nullable();    // when they are called
            $table->integer('awaiting_called_duration')->nullable();
            $table->timestamps();

            $table->index(['room_code', 'created_at'], 'idx_room_code_created');
            $table->index(['room_queue_id', 'created_at'], 'idx_room_queue_id_created');
            $table->index(['room_id', 'created_at'], 'idx_room_id_created');
            $table->index(['room_id', 'created_at', 'process_time_queue_room'], 'idx_room_id_avg_process');
            $table->index(['room_id', 'created_at', 'awaiting_called_duration'], 'idx_room_id_avg_await');

            $table->index(['created_at'], 'idx_created_at_only');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_queue_history_calls');
    }
};
