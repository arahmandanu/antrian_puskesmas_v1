<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Models\LocketQueue;
use App\Models\LocketStaff;
use App\Models\QueueCaller;
use App\Utils\Result;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;

class GetRecallQueue extends \App\Services\AbstractService
{
    protected string $locketCode;
    protected LocketStaff $locketStaff;

    public function __construct(string $locketCode, LocketStaff $locketStaff)
    {
        $this->locketCode = $locketCode;
        $this->locketStaff = $locketStaff;
    }

    public function handle()
    {
        try {
            return DB::transaction(function () {
                // 1️⃣ Check if staff still has a pending queue
                $pendingExist = (new QueueCaller())->isExistPendingByOwnerid($this->locketStaff->id, 'locket');
                if ($pendingExist) {
                    return Result::failure(
                        Lang::get('messages.pending_queue', [
                            'queue' => $pendingExist->formatAsQueueNumber()
                        ], 'id')
                    );
                }

                // 2️⃣ Get the last called queue safely (with lock if needed)
                if (!$this->locketStaff->lastCalledQueue) return Result::failure(Lang::get('messages.empty_history', [], 'id'));

                // 3️⃣ Create a new QueueCaller record (recall)
                QueueCaller::create([
                    'owner_id' => $this->locketStaff->id,
                    'number_code' => $this->locketCode,
                    'called' => false,
                    'type' => 'locket',
                    'lantai' => $this->locketStaff->lantai,
                    'number_queue' => $this->locketStaff->lastCalledQueue->number_queue,
                    'called_to' => $this->createCalledTo(),
                    'initiator_name' => $this->locketStaff->staff_name,
                ]);

                // ✅ Transaction auto-commits if no exception thrown
                return Result::success([
                    'locket_code' => $this->locketCode,
                    'number_queue' => $this->locketStaff->lastCalledQueue->formatAsQueueNumber(false),
                    'locket_number' => $this->locketStaff->locket_number,
                    'poli' => LocketList::from($this->locketCode)->name,
                ], Lang::get('messages.success_call', [], 'id'));
            });
        } catch (\Throwable $e) {
            // Auto rollback already done by DB::transaction()
            return Result::failure('Terjadi kesalahan: ' . $e->getMessage(), null);
        }
    }

    private function createCalledTo(): string
    {
        return LocketList::from($this->locketCode)->hasLocketCode()
            ? "Loket {$this->locketStaff->locket_number}"
            : LocketList::from($this->locketCode)->name;
    }
}
