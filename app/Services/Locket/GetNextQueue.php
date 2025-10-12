<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Models\LocketHistoryCall;
use App\Models\LocketQueue;
use App\Models\LocketStaff;
use App\Models\QueueCaller;
use App\Utils\Result;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;

class GetNextQueue extends \App\Services\AbstractService
{
    protected $locket_code;
    protected $locket_number;

    public function __construct($locket_code, $locket_number)
    {
        $this->locket_code = $locket_code;
        $this->locket_number = $locket_number;
    }

    public function handle()
    {
        try {
            return DB::transaction(function () {
                $locketStaff = LocketStaff::findOrFail($this->locket_number);

                // Check if pending queue exists
                $pendingExist = (new QueueCaller)->isExistPendingByOwnerid($locketStaff->id, 'locket');
                if ($pendingExist) {
                    return Result::failure(Lang::get('messages.pending_queue', [
                        'queue' => $pendingExist->formatAsQueueNumber(),
                    ], 'id'));
                }

                // Get next available queue
                $next = LocketQueue::nextQueue($this->locket_code)->first();
                if (!$next) {
                    return Result::failure(Lang::get('messages.next_queue_is_empty', [], 'id'));
                }

                // Update next queue & staff
                $next->update([
                    'called' => true,
                    'locket_staff_id' => $locketStaff->id,
                ]);

                $locketStaff->update(['last_called_queue_id' => $next->id]);

                // Create queue caller record
                QueueCaller::create([
                    'owner_id' => $locketStaff->id,
                    'number_code' => $this->locket_code,
                    'called' => false,
                    'type' => 'locket',
                    'lantai' => $locketStaff->lantai,
                    'number_queue' => $next->number_queue,
                    'called_to' => $this->createCalledTo($locketStaff),
                    'initiator_name' => $locketStaff->staff_name,
                ]);

                // Record to history
                if ($lastCall = LocketQueue::lastCallByLocketCode($this->locket_code, $locketStaff->id)->first()) {
                    LocketHistoryCall::create([
                        'locket_code' => $this->locket_code,
                        'locket_number' => $locketStaff->locket_number,
                        'locket_staff_id' => $locketStaff->id,
                        'locket_staff_name' => $locketStaff->staff_name,
                        'number_queue' => $lastCall->formatAsQueueNumber(),
                        'process_time_queue_locket' => now()->diffInSeconds($lastCall->created_at),
                    ]);
                }

                // ✅ Transaction auto-commits if we reach here
                return Result::success([
                    'locket_code' => $this->locket_code,
                    'number_queue' => $next->formatAsQueueNumber(false),
                    'locket_number' => $this->locket_number,
                    'poli' => LocketList::from($this->locket_code)->name,
                ], Lang::get('messages.success_call', [], 'id'));
            });
        } catch (\Throwable $e) {
            // Transaction automatically rolled back
            return Result::failure('Terjadi kesalahan: ' . $e->getMessage(), null);
        }
    }

    private function createCalledTo($locketStaff)
    {
        return LocketList::from($this->locket_code)->hasLocketCode()
            ? "Loket {$locketStaff->locket_number}"
            : LocketList::from($this->locket_code)->name;
    }
}
