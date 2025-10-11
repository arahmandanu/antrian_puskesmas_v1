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
    protected $locketCode;
    protected LocketStaff $locketStaff;

    public function __construct($locketCode, $locketStaff)
    {
        $this->locketCode = $locketCode;
        $this->locketStaff = $locketStaff;
    }

    public function handle()
    {
        DB::beginTransaction();
        try {
            $pendingExist = ((new QueueCaller())->isExistPendingByOwnerid($this->locketStaff->id, 'locket'));
            if ($pendingExist) {
                DB::rollBack();
                return Result::failure(Lang::get('messages.pending_queue', ['queue' => $pendingExist->formatAsQueueNumber()], 'id'), null);
            }

            $lastCall = LocketQueue::lastCallByLocketCode($this->locketCode, $this->locketStaff->id)->first();
            if (!$lastCall) {
                DB::rollBack();
                return Result::failure(Lang::get('messages.empty_history', [], 'id'), null);
            }

            QueueCaller::create([
                'owner_id' => $this->locketStaff->id,
                'number_code' =>  $this->locketCode,
                'called' => false,
                'type' => 'locket',
                'lantai' => $this->locketStaff->lantai,
                'number_queue' => $lastCall->number_queue,
                'called_to' => $this->createCalledTo(),
                'initiator_name' => $this->locketStaff->staff_name
            ]);

            DB::commit();
            return Result::success([
                'locket_code' => $this->locketCode,
                'number_queue' => $lastCall->formatAsQueueNumber(false),
                'locket_number' => $this->locketStaff->locket_number,
                'poli' => LocketList::from($this->locketCode)->name,
            ], Lang::get('messages.success_call', [], 'id'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Result::failure('Terjadi kesalahan: ' . $e->getMessage(), null);
        }
    }


    private function createCalledTo()
    {
        if (LocketList::from($this->locketCode)->hasLocketCode()) {
            $name =  "Loket {$this->locketStaff->locket_number}";
        } else {
            $name =  LocketList::from($this->locketCode)->name;
        }

        return $name;
    }
}
