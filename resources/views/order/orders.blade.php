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
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Jumlah Batch</th>
                            <th>Status</th>
                            @if(!auth()->user()->isPpic())
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="align-middle">{{ $order->created_at->toFormattedDateString() }}</td>
                                <td class="align-middle">{{ $order->created_at->addDays(12)->toFormattedDateString() }}</td>
                                <td class="align-middle">{{ $order->no_so }}</td>
                                <td class="align-middle">{{ $order->sales->name }}</td>
                                <td class="align-middle">{{ $order->item->name }}</td>
                                <td class="align-middle">{{ $order->batch->count() }}</td>
                                <td class="align-middle">
                                    @if($today >= $order->created_at->addDays(12))
                                        <span class="badge badge-danger">Late</span>
                                    @else
                                        <span class="badge badge-primary">Ongoing</span>
                                    @endif
                                </td>
                                @if(auth()->user()->isManager())
                                    <td class="align-middle">
                                        <a href="{{ url('orders/detail/'. $order->id) }}"
                                           class="btn btn-primary btn-sm">
                                            Detail
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

    @if(auth()->user()->isManager())
        @include('dashboard.index')
    @endif

@endsection
