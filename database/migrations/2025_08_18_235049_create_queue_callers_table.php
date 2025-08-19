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
        Schema::create('queue_callers', function (Blueprint $table) {
            $table->id();
            $table->string('number_code')->nullable(false);
            $table->string('number_queue')->nullable(false);
            $table->boolean('called')->nullable(false)->default(false);
            $table->string('called_to')->nullable(false);
            $table->string('type')->nullable(false);
            $table->integer('lantai')->default(1)->nullable(false);
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
        Schema::dropIfExists('queue_callers');
    }
};
