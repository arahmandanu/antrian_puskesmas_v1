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
        Schema::create('locket_call', function (Blueprint $table) {
            $table->id();
            $table->text('number_queue')->nullable(false);
            $table->text('locket_code')->nullable(false);
            $table->integer('locket_number')->nullable(true);
            $table->boolean('called')->default(false);
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
        Schema::dropIfExists('locket_call');
    }
};
