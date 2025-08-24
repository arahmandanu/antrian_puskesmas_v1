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
        DB::beginTransaction();
        try {
            $locketStaff = LocketStaff::where('locket_number', $this->locket_number)->first();
            $pendingExist = ((new QueueCaller)->isExistPendingByOwnerid($locketStaff->id, 'locket'));
            if ($pendingExist) {
                DB::rollBack();
                return Result::failure(Lang::get('messages.pending_queue', ['queue' => $pendingExist->formatAsQueueNumber()], 'id'), null);
            }

            $next = LocketQueue::nextQueue($this->locket_code)->first();
            if (!$next) {
                DB::rollBack();
                return Result::failure(Lang::get('messages.next_queue_is_empty', [], 'id'), null);
            }

            $next->called = true;
            $next->locket_number = $this->locket_number;
            $next->save();

            if ($locketStaff) {
                QueueCaller::create([
                    'owner_id' => $locketStaff->id,
                    'number_code' =>  $this->locket_code,
                    'called' => false,
                    'type' => 'locket',
                    'lantai' => $locketStaff->lantai,
                    'number_queue' => $next->number_queue,
                    'called_to' => "loket {$this->locket_number}",
                    'initiator_name' => LocketList::from($this->locket_code)->name
                ]);

                if ($lastCall = LocketQueue::lastCallByLocketCode($this->locket_code, $this->locket_number)->first()) {
                    LocketHistoryCall::create([
                        'locket_code' => $this->locket_code,
                        'locket_number' =>  $locketStaff->locket_number,
                        'locket_staff_name' => $locketStaff->staff_name,
                        'number_queue' => $lastCall->number_queue,
                        'process_time_queue_locket' => now()->diffInSeconds($lastCall->created_at)
                    ]);
                }
            }

            DB::commit();
            return Result::success([
                'locket_code' => $this->locket_code,
                'number_queue' => $next->number_queue,
                'locket_number' => $this->locket_number,
                'poli' => LocketList::from($this->locket_code)->name
            ], Lang::get('messages.success_call', [], 'id'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Result::failure('Terjadi kesalahan: ' . $e->getMessage(), null);
        }
    }
}
