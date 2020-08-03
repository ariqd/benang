@extends('layouts.admin')

@section('title')
Order List
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <h4>Batch Order Saat Ini</h4>
        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. SO</th>
                        <th>No. Batch</th>
                        <th>Nama Customer</th>
                        <th>Item</th>
                        <th>Color</th>
                        <th>Qty</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $pivot)
                        <tr>
                            <td class="align-middle">{{ $pivot->batch->order->no_so }}</td>
                            <td class="align-middle">{{ $pivot->batch->id }}</td>
                            <td class="align-middle">{{ $pivot->batch->order->sales->name }}</td>
                            <td class="align-middle">{{ $pivot->batch->order->item->name }}</td>
                            <td class="align-middle">{{ $pivot->batch->color->name }}</td>
                            <td class="align-middle">{{ $pivot->batch->qty }}</td>
                            <td class="align-middle">{{ $pivot->created_at->toFormattedDateString() }}</td>
                            <td class="align-middle">{{ $pivot->created_at->addDays(12)->toFormattedDateString() }}</td>
                            {{-- <td class="align-middle">{{ $pivot->order->end_date }}</td> --}}
                            <td class="align-middle">
                                @if($today >= $pivot->created_at->addDays(12)))
                                    <span class="badge badge-danger">Late</span>
                                @else
                                    <span class="badge badge-primary">Aktif</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($today <= $pivot->created_at->addDays(12))
                                    @if($pivot->user()->exists())
                                        <a href="{{ route('orders.show', $pivot->batch->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-check"></i> Tandai sebagai selesai
                                        </a>
                                    @else
                                        <a href="{{ route('orders.edit', $pivot->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-check"></i> Mulai produksi
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
