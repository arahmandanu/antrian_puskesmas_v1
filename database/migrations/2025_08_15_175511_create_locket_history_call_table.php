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
        Schema::create('locket_history_call', function (Blueprint $table) {
            $table->id();
            $table->string('locket_code')->nullable(false);
            $table->integer('locket_number')->nullable();
            $table->text('locket_staff_name')->nullable();
            $table->text('number_queue')->nullable();
            $table->integer('process_time_queue_locket')->nullable();
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
        Schema::dropIfExists('locket_history_call');
    }
};
