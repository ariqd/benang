@extends('layouts.admin')

@section('title')
    Order List
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endpush

@push('js')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').dataTable({
                "pageLength": 5,
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "order": [],
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }]
            });
        });

    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h4>Batch Order Saat Ini (Ongoing)</h4>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="datatable">
                        <thead>
                        <tr>
                            <th>Mulai</th>
                            <th>Deadline</th>
                            <th>No. SO</th>
                            <th>Step</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Warna</th>
                            <th>Qty</th>
                            <th>After Error</th>
                            <th>Terproses</th>
                            <th>Error</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            @if(!auth()->user()->isPpic())
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $pivot)
                            <tr>
                                <td class="align-middle">{{ $pivot->created_at->toFormattedDateString() }}</td>
                                <td class="align-middle">{{ $pivot->created_at->addDays(12)->toFormattedDateString() }}</td>
                                <td class="align-middle">{{ $pivot->batch->order->no_so }}</td>
                                <td class="align-middle">{{ $pivot->step }}</td>
                                <td class="align-middle">{{ $pivot->batch->order->sales->name }}</td>
                                <td class="align-middle">{{ $pivot->batch->order->item->name }}</td>
                                <td class="align-middle">{{ $pivot->batch->color->name }}</td>
                                <td class="align-middle">{{ $pivot->batch->qty }} Kg</td>
                                <td class="align-middle">{{ $pivot->qty_before_this_step }} Kg</td>
                                <td class="align-middle text-success">{{ $pivot->current_step_processed }} Kg</td>
                                <td class="align-middle text-danger">{{ $pivot->current_step_errors }} Kg</td>
                                <td class="align-middle text-primary">{{ $pivot->qty_before_this_step - $pivot->current_step_processed }}
                                    Kg
                                </td>
                                <td class="align-middle">
                                    @if($today >= $pivot->created_at->addDays(12))
                                        <span class="badge badge-danger">Late</span>
                                    @else
                                        @if($pivot->batch->order->status == 'DONE')
                                            <span class="badge badge-success">Done</span>
                                        @else
                                            <span class="badge badge-primary">Ongoing</span>
                                        @endif
                                    @endif
                                </td>
                                @if(!auth()->user()->isManager() && !auth()->user()->isPpic())
                                    <td class="align-middle">
                                        @if($today <= $pivot->created_at->addDays(12))
                                            @if($pivot->user()->exists())
                                                <a href="{{ route('orders.show', $pivot->id) }}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fa fa-check"></i> Tandai selesai ({{ $pivot->processed }}
                                                    Kg)
                                                </a>
                                            @else
                                                <a href="{{ route('orders.edit', $pivot->id) }}"
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fa fa-check"></i> Mulai produksi
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                @endif
                                @if(auth()->user()->isManager())
                                    <td class="align-middle">
                                        <a href="{{ url('orders/detail/'. $pivot->id) }}"
                                           class="btn btn-primary btn-sm">
                                            Show
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">No data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

{{--    @if(auth()->user()->isManager())--}}
{{--        @include('dashboard.index')--}}
{{--    @endif--}}


@endsection
