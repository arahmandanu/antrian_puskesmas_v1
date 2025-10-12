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
            $table->foreignId('locket_staff_id')
                ->nullable()
                ->constrained('locket_staff') // 👈 must match the $table property
                ->cascadeOnDelete();
            $table->unsignedSmallInteger('number_queue'); // lebih hemat dari string
            $table->boolean('called')->nullable(false)->default(false);
            $table->timestamps();

            // composite index
            $table->index(['locket_code', 'called', 'created_at']);
            $table->index(['locket_code', 'created_at', 'id']);
            $table->index(['locket_code', 'created_at', 'id'], 'idx_locket_code_created_id');
            // unique index
            $table->unique(['locket_code', 'number_queue', 'called'], 'uq_locket_queue_code_number_called');
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
