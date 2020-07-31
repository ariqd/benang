@extends('layouts.admin')

@section('title')
Order List
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <h5>Order saat ini</h5>
        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. SO</th>
                        <th>Nama Customer</th>
                        <th>Sales</th>
                        <th>Item</th>
                        <th>Color</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $pivot)
                        <tr>
                            <td class="align-middle">{{ $pivot->order->no_so }}</td>
                            <td class="align-middle">{{ $pivot->order->customer_name }}</td>
                            <td class="align-middle">{{ $pivot->order->sales->name }}</td>
                            <td class="align-middle">{{ $pivot->order->item->name }}</td>
                            <td class="align-middle">{{ $pivot->order->color->name }}</td>
                            <td class="align-middle">{{ $pivot->order->start_date }}</td>
                            <td class="align-middle">{{ $pivot->order->end_date }}</td>
                            <td class="align-middle">
                                @if($today >= Carbon\Carbon::createFromFormat('Y-m-d', $pivot->order->end_date))
                                    <span class="badge badge-danger">Late</span>
                                @else
                                    <span class="badge badge-primary">Aktif</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($today <= Carbon\Carbon::createFromFormat('Y-m-d', $pivot->order->end_date))
                                    @if($pivot->user()->exists())
                                        <a href="{{ route('orders.show', $pivot->order->id) }}" class="btn btn-primary btn-sm">
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
