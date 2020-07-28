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
    {{-- <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.5.7/dist/cleave.min.js"></script> --}}
    {{-- <script src="{{ asset('assets') }}/js/datatables.min.js"></script> --}}
    <script>
        const today = new Date();
        const date_start = document.getElementById('date_start');
        const date_finish = document.getElementById('date_finish');
        date_start.value = today.toISOString().substr(0, 10);
        date_start.min = today.toISOString().substr(0, 10);
        date_finish.value = today.toISOString().substr(0, 10);

        $(document).ready(function () {
            $('.select2').select2();
        });

    </script>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Halaman ini masih dalam tahap pengembangan. --}}

                <form action="{{ route('orders.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="customer">Nama Customer</label>
                        <input type="text" name="customer" id="customer" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="sales">Sales</label>
                        <select class="form-control select2" name="sales_id" id="sales">
                            <option value="" selected disabled>- Pilih Sales -</option>
                            @foreach($sales as $sales)
                                <option value="{{ $sales->id }}">
                                    {{ $sales->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="items">Item</label>
                        <select class="form-control select2" name="item_id" id="items">
                            <option value="" selected disabled>- Pilih Item -</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="colors">Warna</label>
                        <select class="form-control select2" name="color_id" id="colors">
                            <option value="" selected disabled>- Pilih Warna -</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">
                                    {{ $color->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="quantity" class="col-form-label col-12">Jumlah (Kg)</label>
                        <div class="col-4">
                            <input type="number" name="quantity" id="quantity" class="form-control" min="0" value="1">
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <div class="col-5">
                            <label for="date_start">Tanggal Mulai</label>
                            <input type="date" name="date_start" id="date_start" class="form-control">
                        </div>

                        <div class="col-2 text-center">
                            <i class="fa fa-arrow-right"></i>
                        </div>

                        <div class="col-5">
                            <label for="date_finish">Tanggal Selesai</label>
                            <input type="date" name="date_finish" id="date_finish" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary float-right">Tambahkan Order Baru</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
