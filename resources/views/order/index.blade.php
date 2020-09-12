@extends('layouts.admin')

@section('title')
Order List
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <h4>Batch Order Saat Ini (Ongoing)</h4>
        <div class="card">
            <div class="table-responsive">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. SO</th>
                            <th>No. Batch</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Warna</th>
                            <th>Qty</th>
                            <th>Terproses</th>
                            <th>Error</th>
                            <th>Sisa</th>
                            <th>Mulai</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            @if(!auth()->user()->isManager())
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $pivot)
                        {{-- @php
                        dd();
                    @endphp --}}
                        <tr>
                            <td class="align-middle">{{ $pivot->batch->order->no_so }}</td>
                            <td class="align-middle">{{ $pivot->batch->id }}</td>
                            <td class="align-middle">{{ $pivot->batch->order->sales->name }}</td>
                            <td class="align-middle">{{ $pivot->batch->order->item->name }}</td>
                            <td class="align-middle">{{ $pivot->batch->color->name }}</td>
                            <td class="align-middle">{{ $pivot->batch->qty }} Kg</td>
                            {{-- <td class="align-middle">{{ App\OrderUser::where('batch_id', $pivot->batch_id)->sum('processed') }} Kg</td> --}}
                            <td class="align-middle text-success">{{ $pivot->current_step_processed }} Kg</td>
                            <td class="align-middle text-danger">{{ $pivot->current_step_errors }} Kg</td>
                            <td class="align-middle text-primary">{{ $pivot->current_step_qty }} Kg</td>
                            <td class="align-middle">{{ $pivot->created_at->toFormattedDateString() }}</td>
                            <td class="align-middle">{{ $pivot->created_at->addDays(12)->toFormattedDateString() }}</td>
                            <td class="align-middle">
                                @if($today >= $pivot->created_at->addDays(12))
                                <span class="badge badge-danger">Late</span>
                                @else
                                <span class="badge badge-primary">Aktif</span>
                                @endif
                            </td>
                            @if(!auth()->user()->isManager())
                            <td class="align-middle">
                                @if($today <= $pivot->created_at->addDays(12))
                                    @if($pivot->user()->exists())
                                    <a href="{{ route('orders.show', $pivot->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-check"></i> Tandai selesai ({{ $pivot->processed }} Kg)
                                    </a>
                                    @else
                                    <a href="{{ route('orders.edit', $pivot->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-check"></i> Mulai produksi
                                    </a>
                                    @endif
                                    @endif
                            </td>
                            @endif
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
</div>
@endsection