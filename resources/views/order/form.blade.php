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
                    <form action="{{ route('orders.update', $pivot->id) }}" method="POST">
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
                                {{-- <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade_error" value="ERROR">
                                    <label class="form-check-label" for="grade_error">Error</label>
                                </div> --}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="error" class="col-12">Error Qty.</label>
                            <div class="col-4">
                                <input type="number" name="error" id="error" class="form-control" value="0" max="{{ $pivot->batch->qty }}">
                                <small class="text-muted">Maksimal {{ $actual_qty }} pcs</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" {{ $actual_qty > 0 ? '' : 'disabled' }}>
                                Tandai sebagai selesai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@elseif(@$startOrder)

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Mulai Produksi Order #{{ $pivot->batch->order->no_so }}</h5>
                    <form action="{{ route('orders.update', $pivot->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @foreach($engines as $engine)
                            <div class="form-group form-row">
                                <label for="process_qty" class="col-form-label col-12 col-md-3 text-right">Mesin {{ $engine->name }} (Kg)</label>
                                <div class="col-12 col-md-6">
                                    <input type="number" name="process_qty" id="process_qty" class="form-control" value="0" max="{{ $pivot->batch->qty }}">
                                    {{-- <small class="text-muted">Maksimal {{ $actual_qty }} pcs</small> --}}
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group row">
                            <div class="col-12 col-md-6 offset-3">
                                <button type="submit" class="btn btn-primary" {{ $actual_qty > 0 ? '' : 'disabled' }}>
                                    Mulai Produksi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>@endif

    @if($pivots)
        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <div class="card">
                    <table class="table">
                        <thead>
                            <th>No.</th>
                            <th>Proses</th>
                            <th>Grade</th>
                            <th>Error</th>
                        </thead>
                        <tbody>
                            @forelse($pivots as $process)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ App\OrderUser::step($process->step) }}</td>
                                    <td>{{ $process->grade }}</td>
                                    <td>{{ $process->error }} Kg</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Tidak ada proses sebelumnya.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right">Qty Batch:</td>
                                <td>{{ $pivot->batch->qty }} Kg</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Total Error:</td>
                                <td>{{ $pivots->sum('error') }} Kg</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Qty Sekarang:</strong></td>
                                <td><b>{{ $actual_qty }} Kg</b></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="no_so">Sales Order No.</label>
                            <input type="text" name="no_so" id="no_so" class="form-control" value="{{ @$show || @$startOrder ? @$pivot->batch->order->no_so : $no_so }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="batch_id">Batch No.</label>
                            <input type="text" name="batch_id" id="batch_id" class="form-control" value="{{ @$show || @$startOrder ? @$pivot->batch->id : $id }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="sales">Customer</label>
                            <select class="form-control select2" name="sales_id" id="sales" @if(@$show) disabled @endif>
                                <option value="" selected disabled>- Pilih Customer -</option>
                                @foreach($sales as $sales)
                                    <option value="{{ $sales->id }}" @if(@$show && (@$pivot->batch->order->sales->id == @$sales->id)) selected @endif>
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
                                    <option value="{{ $item->id }}" @if(@$show && (@$pivot->batch->order->item->id == @$item->id)) selected @endif>
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
                                    <option value="{{ $color->id }}" @if(@$show && (@$pivot->batch->color->id == @$color->id)) selected @endif>
                                        {{ $color->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="qty" class="col-form-label col-12">Jumlah (Kg)</label>
                            <div class="col-4">
                                <input type="number" name="qty" id="qty" class="form-control" min="0" value="{{ @$show || @$startOrder ? $pivot->batch->qty : 1 }}" {{ @$show || @$startOrder ? 'disabled' : '' }}>
                            </div>
                        </div>

                        @if(@$show)
                            <div class="form-group row">
                                <label for="qty" class="col-form-label col-12">Jumlah Setelah Error (Kg)</label>
                                <div class="col-4">
                                    <input type="number" name="qty" id="qty" class="form-control" min="0" value="{{ @$show || @$startOrder ? $actual_qty : 1 }}" {{ @$show || @$startOrder ? 'disabled' : '' }}>
                                </div>
                            </div>
                        @endif

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
