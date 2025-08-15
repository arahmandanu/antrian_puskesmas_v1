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
            $table->string('code')->unique();
            $table->text('name')->nullable();
            $table->text('current_queue')->nullable();
            $table->integer('number_display')->default(0)->nullable(false);
            $table->boolean('show')->default(true);
            $table->integer('lantai')->default(0)->nullable(false);
            $table->text('staff_name')->nullable();
            $table->text('last_call_queue')->nullable();
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
