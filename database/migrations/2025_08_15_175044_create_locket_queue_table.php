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
        Schema::create('locket_queue', function (Blueprint $table) {
            $table->id();
            $table->string('locket_code')->nullable(false);
            $table->integer('locket_number')->nullable(true);
            $table->string('number_queue')->nullable(false);
            $table->boolean('called')->nullable(false)->default(false);
            $table->timestamps();

            // composite index
            $table->index(['called', 'created_at']);

            // unique index
            $table->unique(['locket_code', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locket_queue');
    }
};
