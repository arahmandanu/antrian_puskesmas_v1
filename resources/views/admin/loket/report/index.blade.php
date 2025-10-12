@extends('admin.shared.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loket Report</h1>
            </div>
        </div>

        <!-- Locket Report Section -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Locket History Report</h3>
                    </div>

                    <div class="panel-body">
                        <form method="GET" action="{{ route('admin.loket.report.index') }}" class="form-inline mb-3 pb-3">
                            <div class="form-group mr-2">
                                <label for="start_date" class="mr-2">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>

                            <div class="form-group mr-2">
                                <label for="end_date" class="mr-2">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>

                        @if (isset($report) && $report->count())
                            <table class="table table-bordered table-striped" id="report-table">
                                <thead>
                                    <tr>
                                        <th>Staff ID</th>
                                        <th>Nama Staff</th>
                                        <th>Total Antrian Terpanggil</th>
                                        <th>Average Process Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($report as $row)
                                        <tr>
                                            <td>{{ $row->locket_staff->id ?? '-' }}</td>
                                            <td>{{ $row->locket_staff->staff_name ?? '-' }}
                                                {{ $row->locket_staff->locket_number ?? '' }}</td>
                                            <td>{{ $row->total_calls }}</td>
                                            <td>{{ humanize_seconds(round($row->avg_process_time)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No report data found for the selected period.</p>
                        @endif
                    </div>

                    <div class="row mt-4 mb-4">
                        <div class="col-lg-3">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Antrian Populer</h3>
                                </div>
                                <div class="panel-body">
                                    <canvas id="queueDoughnutChart" style="height: 250px;"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-9">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Total Antrian Per Hari</h3>
                                </div>
                                <div class="panel-body">
                                    <canvas id="stackedChart" style="height: 350px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#report-table').DataTable({
                responsive: true,
                columnDefs: [],
                autoWidth: false,
                language: {
                    emptyTable: "No Loket found"
                }
            });
        });

        const ctx = document.getElementById('queueDoughnutChart').getContext('2d');
        const queueChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($queueData->pluck('name')) !!},
                datasets: [{
                    label: 'Total Calls',
                    data: {!! json_encode($queueData->pluck('total')) !!},
                    backgroundColor: {!! json_encode($queueData->pluck('color')) !!},
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw + ' calls';
                            }
                        }
                    }
                }
            }
        });

        const ctxStacked = document.getElementById('stackedChart').getContext('2d');

        const stackedChart = new Chart(ctxStacked, {
            type: 'bar', // can also try 'line' with stacked: true
            data: {
                labels: {!! json_encode($dates) !!},
                datasets: {!! json_encode($datasets) !!}
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw + ' queues';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Queues'
                        }
                    }
                }
            }
        });
    </script>
@endsection
