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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable(false);
            $table->text('name')->nullable(false);
            $table->text('current_queue')->nullable();
            $table->boolean('show')->default(true);
            $table->integer('lantai')->default(0)->nullable(false);
            $table->text('last_call_queue')->nullable();
            $table->dateTime('last_call_time')->nullable();
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
        Schema::dropIfExists('rooms');
    }
};
