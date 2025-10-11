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
            $table->integer('owner_id')->nullable(false);
            $table->string('number_code')->nullable(false);
            $table->string('number_queue')->nullable(false);
            $table->string('initiator_name')->nullable(false);
            $table->boolean('called')->nullable(false)->default(false);
            $table->string('called_to')->nullable(false);
            $table->string('type')->nullable(false);
            $table->unsignedTinyInteger('lantai')->default(1)->nullable(false);
            $table->timestamps();

            // ✅ For lastCallByCode()  → filter by number_code, called, created_at + order by id
            $table->index(['number_code', 'called', 'created_at', 'id'], 'idx_last_call_by_code');

            // ✅ For isExistPendingByOwnerid()  → owner_id, type, called, created_at
            $table->index(['owner_id', 'type', 'called', 'created_at'], 'idx_exist_pending_owner');

            // ✅ For lastCallByOwnerid()  → same filter, add id for ORDER BY optimization
            $table->index(['owner_id', 'type', 'called', 'created_at', 'id'], 'idx_last_call_by_owner');

            // ✅ For dashboard / stats → lantai, called, created_at
            $table->index(['lantai', 'called', 'created_at'], 'idx_lantai_called_created');

            // ✅ Optional (keep if you sometimes query by created_at only)
            $table->index(['created_at'], 'idx_created_at');
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
