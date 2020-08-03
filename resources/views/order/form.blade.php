@extends('layouts.admin')

@section('title')
Order Form
@endsection

@push('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/datatables.min.css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    {{-- <script src="{{ asset('assets') }}/js/datatables.min.js"></script> --}}
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });

    </script>
@endpush

@section('content')

@if(@$show)
    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="grade">Grade</label>
                            <div class="form-control">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade_a" value="A" checked>
                                    <label class="form-check-label" for="grade_a">A</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade_b" value="B">
                                    <label class="form-check-label" for="grade_b">B</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade_c" value="C">
                                    <label class="form-check-label" for="grade_c">C</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade_error" value="ERROR">
                                    <label class="form-check-label" for="grade_error">Error</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Tandai sebagai selesai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="no_so">No. Order</label>
                        <input type="text" name="no_so" id="no_so" class="form-control" value="{{ @$show ? @$order->no_so : $no_so }}" readonly>
                    </div>

                    {{-- <div class="form-group">
                        <label for="customer_name">Nama Customer</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control" @if(@$show) value="{{ @$order->customer_name }}" disabled @endif>
                    </div> --}}

                    <div class="form-group">
                        <label for="sales">Customer</label>
                        <select class="form-control select2" name="sales_id" id="sales" @if(@$show) disabled @endif>
                            <option value="" selected disabled>- Pilih Customer -</option>
                            @foreach($sales as $sales)
                                <option value="{{ $sales->id }}" @if(@$show && (@$order->sales->id == @$sales->id)) selected @endif>
                                    {{ $sales->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="items">Item</label>
                        <select class="form-control select2" name="item_id" id="items" @if(@$show) disabled @endif>
                            <option value="" selected disabled>- Pilih Item -</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" @if(@$show && (@$order->item->id == @$item->id)) selected @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="colors">Warna</label>
                        <select class="form-control select2" name="color_id" id="colors" @if(@$show) disabled @endif>
                            <option value="" selected disabled>- Pilih Warna -</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}" @if(@$show && (@$order->color->id == @$color->id)) selected @endif>
                                    {{ $color->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="qty" class="col-form-label col-12">Jumlah (Kg)</label>
                        <div class="col-4">
                            <input type="number" name="qty" id="qty" class="form-control" min="0" value="{{ @$show ? $order->qty : 1 }}" {{ @$show ? 'disabled' : '' }}>
                        </div>
                    </div>

                    {{-- <div class="form-group form-row align-items-center">
                        <div class="col-5">
                            <label for="start_date">Tanggal Mulai</label>
                            @if(@$show)
                                <input type="text" name="start_date" id="start_date" class="form-control" @if(@$show) value="{{ @$order->start_date }}" disabled @endif>
                            @else
                                <input type="date" name="start_date" id="start_date" class="form-control" min="{{ $today->format('Y-m-d') }}" value="{{ $today->format('Y-m-d') }}">
                            @endif
                        </div>

                        <div class="col-2 text-center">
                            <i class="fa fa-arrow-right"></i>
                        </div>

                        <div class="col-5">
                            <label for="end_date">Tanggal Selesai</label>
                            @if(@$show)
                                <input type="text" name="end_date" id="end_date" class="form-control" @if(@$show) value="{{ @$order->end_date }}" disabled @endif>
                            @else
                                <input type="date" name="end_date" id="end_date" class="form-control" min="{{ $today->addDay()->format('Y-m-d') }}" value="{{ $today->addDay()->format('Y-m-d') }}">
                            @endif
                        </div>
                    </div> --}}

                    <div class="form-group">
                        @if(@!$show)
                            <button type="submit" class="btn btn-primary float-right">Tambahkan Order Baru</button>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
