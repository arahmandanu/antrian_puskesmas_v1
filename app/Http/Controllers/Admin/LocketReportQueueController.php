<?php

namespace App\Http\Controllers\Admin;

use App\Enum\LocketList;
use App\Http\Controllers\Controller;
use App\Models\LocketHistoryCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class LocketReportQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->subDays(7)->startOfDay();

        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfDay();

        if ($startDate->diffInDays($endDate) > 7) {
            throw ValidationException::withMessages([
                'date_range' => 'Rentang tanggal maksimal hanya 7 hari.',
            ]);
        }

        $datas = LocketHistoryCall::with('staff')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $report = $datas->groupBy('locket_staff_id')
            ->map(function ($group) {
                return (object)[
                    'locket_staff' => $group->first()->staff, // related LocketStaff model
                    'total_calls' => $group->count(),
                    'avg_process_time' => $group->avg('process_time_queue_locket')
                ];
            })
            ->sortByDesc('total_calls');

        $queueData = LocketHistoryCall::select('locket_code', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('locket_code')
            ->orderByDesc('total')
            ->get()
            ->map(function ($row) {
                $enum = LocketList::tryFrom($row->locket_code); // returns null if not found
                $row->name = $enum ? $enum->title() : $row->locket_code; // human-readable title
                $row->color = $enum ? $enum->color() : '#888888'; // optional for chart colors
                return $row;
            });


        // Get all relevant locket codes
        $codes = LocketList::toArray();
        // Query grouped by date and locket_code
        $dailyQueues = LocketHistoryCall::select(
            DB::raw('DATE(created_at) as date'),
            'locket_code',
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'), 'locket_code')
            ->orderBy('date')
            ->get();

        // Prepare dataset per locket code
        $dates = $dailyQueues->pluck('date')->unique()->sort()->values(); // all dates
        $datasets = [];

        foreach ($codes as $codeValue) {
            $enum = LocketList::tryFrom($codeValue);
            $color = $enum ? $enum->color() : '#888888';
            $label = $enum ? $enum->title() : $codeValue;

            $data = $dates->map(
                fn($date) => $dailyQueues->firstWhere('date', $date)?->locket_code === $codeValue
                    ? $dailyQueues->firstWhere(fn($row) => $row->date === $date && $row->locket_code === $codeValue)->total
                    : 0
            );

            $datasets[] = [
                'label' => $label,
                'data' => $data,
                'backgroundColor' => $color,
                'stack' => 'Stack 0', // enable stacking
            ];
        }

        return view('admin.loket.report.index', [
            'report' => $report,
            'queueData' => $queueData,
            'dates' => $dates,
            'datasets' => $datasets,
            'dailyQueues' => $dailyQueues,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
