<?php

namespace App\Services\Room;

use App\Models\QueueCaller;
use App\Models\Room;
use App\Utils\Result;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;

class ReCallQueue extends \App\Services\AbstractService
{
    protected Room $room;

    public function __construct($room)
    {
        $this->room = $room;
    }

    public function handle()
    {
        DB::beginTransaction();
        try {
            $pendingExist = (new QueueCaller())->isExistPendingByOwnerid($this->room->id, 'poli');
            if ($pendingExist) {
                DB::rollBack();
                return Result::failure(Lang::get('messages.pending_queue', ['queue' => $pendingExist->formatAsQueueNumber()], 'id'));
            }

            $result = $this->room->queuesCalled()
                ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
                ->take(1)->first();
            if (!$result) {
                DB::rollBack();
                return Result::failure(Lang::get('messages.empty_history', [], 'id'), null);
            }

            QueueCaller::create([
                'owner_id' => $this->room->id,
                'number_code' =>  $result->room_code,
                'called' => false,
                'type' => 'poli',
                'lantai' => $this->room->lantai,
                'number_queue' => $result->number_queue,
                'called_to' => $this->room->name,
                'initiator_name' => "Poli"
            ]);

            DB::commit();
            return Result::success($result, Lang::get('messages.success_retrive_data', [], 'id'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Result::failure('Terjadi kesalahan: ' . $e->getMessage(), null);
        }
    }
}
