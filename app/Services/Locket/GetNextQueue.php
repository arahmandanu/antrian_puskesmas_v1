<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Helpers\DateRangeHelper;
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
    protected $timeNow;

    public function __construct($locket_code, $locket_number)
    {
        $this->locket_code = $locket_code;
        $this->locket_number = $locket_number;
        $this->timeNow = now();
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
                    $this->updateLastHistory($locketStaff);
                    return Result::failure(Lang::get('messages.next_queue_is_empty', [], 'id'));
                }

                // Update next queue & staff
                $next->update([
                    'called' => true,
                    'locket_staff_id' => $locketStaff->id,
                ]);

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

                // Create locket history call
                // initiate first call
                LocketHistoryCall::create([
                    'locket_queue_id' => $next->id,
                    'locket_code' => $this->locket_code,
                    'locket_number' => $locketStaff->locket_number,
                    'locket_staff_id' => $locketStaff->id,
                    'locket_staff_name' => $locketStaff->staff_name,
                    'number_queue' => $next->formatAsQueueNumber(),
                    'process_time_queue_locket' => null,
                    'called_at' => $this->timeNow,
                    'awaiting_called_duration' => $this->timeNow->diffInSeconds($next->created_at),
                ]);

                // Record to history (It shound update all detail history)
                $this->updateLastHistory($locketStaff);
                $locketStaff->update(['last_called_queue_id' => $next->id]);

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

    private function updateLastHistory($locketStaff)
    {
        if ($history = LocketHistoryCall::where('locket_queue_id', $locketStaff->last_called_queue_id)
            ->whereNull('process_time_queue_locket')
            ->whereBetween('created_at', DateRangeHelper::daysAgoToNow(0))
            ->first()
        ) {
            # update after next call
            $updated = $history->update([
                'process_time_queue_locket' => $this->timeNow->diffInSeconds($history->created_at)
            ]);

            if (!$updated) {
                throw new \RuntimeException("Failed to update process_time_queue_room for history ID: {$history->id}");
            }
        }
    }

    private function createCalledTo($locketStaff)
    {
        return LocketList::from($this->locket_code)->hasLocketCode()
            ? "Loket {$locketStaff->locket_number}"
            : LocketList::from($this->locket_code)->name;
    }
}
