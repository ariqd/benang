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
        $count = 1

        // $('.select2').select2();

        // function addCount() {
        //     return $count++
        // }

        // function subCount() {
        //     return $count--
        // }

        $('#tambah-batch').click(function() {
            $count++

            $('#batches').append('<div class="form-row my-3" id="batch-'+$count+'">\
                        <div class="col-1">\
                            <p>#' + $count + '</p>\
                        </div>\
                        <div class="col-10">\
                            <div class="form-group">\
                                <select class="form-control" name="batches['+$count+'][color]" id="colors" @if(@$show) disabled @endif>\
                                    <option value="" selected disabled>- Pilih Warna -</option>\
                                    @foreach($colors as $color)\
                                    <option value="{{ $color->id }}" @if(@$show && (@$pivot->batch->color->id == @$color->id)) selected @endif>\
                                        {{ $color->name }}\
                                    </option>\
                                    @endforeach\
                                </select>\
                            </div>\
                            <div class="form-group form-row align-items-center">\
                                <div class="col-9 col-lg-2">\
                                    <input type="number" name="batches['+$count+'][qty]" id="qty" class="form-control" min="0" value="{{ @$show || @$startOrder ? $pivot->batch->qty : 1 }}" {{ @$show || @$startOrder ? 'disabled' : '' }}>\
                                </div>\
                                <div class="col-3">\
                                    Kilogram\
                                </div>\
                            </div>\
                        </div>\
                        <div class="col-1 text-center">\
                            <button type="button" class="btn btn-icon btn-light" id="hapus-batch" data-key="'+$count+'">\
                                <i class="fa fa-times text-danger"></i>\
                            </button>\
                        </div>\
                    </div>')
        })

        $('#batches').on('click', '#hapus-batch', function() {
            const key = $(this).data("key")
            $count--
            $('#batch-'+key).remove()
        })

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
                            <input type="number" name="error" id="error" class="form-control" placeholder="0" max="{{ $pivot->batch->qty }}">
                            <small class="text-muted">Maksimal {{ $pivot->usage->sum('qty') }} kg</small>
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
@elseif(@$startOrder)
<div class="row justify-content-center mb-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Mulai Produksi Order #{{ $pivot->batch->order->no_so }}</h5>
                <form action="{{ url('orders/start/' . $pivot->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group form-row">
                        <label for="qty" class="col-form-label col-12 col-md-3 text-right">Qty Setelah Error / Sisa</label>
                        <div class="col-12 col-md-6">
                            <input type="number" name="qty" id="qty" class="form-control" min="0" value="{{ @$show || @$startOrder ? $pivot->qty_before_this_step - $pivot->current_step_processed : 1 }}" {{ @$show || @$startOrder ? 'readonly' : '' }}>
                        </div>
                        <div class="col-12 col-md-3">
                            <small class="text-muted">Kg</small>
                        </div>
                    </div>

                    @foreach($engines as $engine)
                    @if($engine->capacity - $engine->usage->where('active', TRUE)->sum('qty') > 0)
                    <div class="form-group form-row align-items-center">
                        <label for="process_qty_{{ $engine->id }}" class="col-form-label col-12 col-md-3 text-right">Mesin {{ $engine->name }} (Max. {{ $engine->capacity - $engine->usage->where('active', TRUE)->sum('qty') }} Kg)</label>
                        <div class="col-12 col-md-3">
                            <input type="number" name="process_qty[{{ $engine->id }}]" id="process_qty_{{ $engine->id }}" class="form-control" value="{{ old('process_qty.'.$engine->id) }}" placeholder="0" max="{{ $engine->capacity - $engine->usage->where('active', TRUE)->sum('qty') }}">
                        </div>
                        <div class="col-12 col-md-3">
                            <small class="text-muted">Kg</small>
                        </div>
                    </div>
                    @endif
                    @endforeach

                    <div class="form-group row">
                        <div class="col-12 col-md-6 offset-3">
                            <button type="submit" class="btn btn-primary" {{ $pivot->current_step_qty > 0 ? '' : 'disabled' }}>
                                Mulai Produksi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>@endif

@if(@$pivots)
<div class="row justify-content-center mb-3">
    <div class="col-md-8">
        <div class="card">
            <table class="table">
                <thead>
                    <th>No.</th>
                    <th>Proses</th>
                    <th>Diproses</th>
                    <th>Grade</th>
                    <th>Error</th>
                </thead>
                <tbody>
                    @forelse($pivots as $process)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ App\OrderUser::step($process->step) }}</td>
                        <td>{{ $process->processed }} Kg</td>
                        <td>{{ $process->grade }}</td>
                        <td>{{ $process->error }} Kg</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Tidak ada proses sebelumnya.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">Qty Batch:</td>
                        <td>{{ $pivot->batch->qty }} Kg</td>
                    </tr>
                    {{-- <tr>
                        <td colspan="4" class="text-right">Total Diproses:</td>
                        <td>{{ $pivot->current_step_processed }} Kg</td>
                    </tr> --}}
                    <tr>
                        <td colspan="4" class="text-right">Total Error:</td>
                        <td>{{ $pivot->total_errors }} Kg</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Sisa Qty:</strong></td>
                        <td><b>{{ $pivot->qty_after_errors }} Kg</b></td>
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

                    @if(@$show || @$startOrder)
                    <div class="form-group">
                        <label for="batch_id">Batch No.</label>
                        <input type="text" name="batch_id" id="batch_id" class="form-control" value="{{ @$pivot->batch->id }}" readonly>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="sales">Customer</label>
                        <select class="form-control select2" name="sales_id" id="sales" @if(@$show || @$mulaiProduksi) disabled @endif>
                            <option value="" selected disabled>- Pilih Customer -</option>
                            @foreach($sales as $sales)
                            <option value="{{ $sales->id }}" @if(@$show || (@$pivot->batch->order->sales->id == @$sales->id)) selected @endif>
                                {{ $sales->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="items">Item</label>
                        <select class="form-control select2" name="item_id" id="items" @if(@$show || @$mulaiProduksi) disabled @endif>
                            <option value="" selected disabled>- Pilih Item -</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" @if(@$show || (@$pivot->batch->order->item->id == @$item->id)) selected @endif>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <h4 class="pt-4 pb-2">Batch</h4>

                    @if(@!$show && @!$mulaiProduksi)
                    <div class="form-row">
                        <div class="col-1">
                            <p>#1</p>
                        </div>
                        <div class="col-10">
                            <div class="form-group">
                                {{-- <label for="colors">Warna</label> --}}
                                <select class="form-control" name="batches[0][color]" id="colors" @if(@$show) disabled @endif>
                                    <option value="" selected disabled>- Pilih Warna -</option>
                                    @foreach($colors as $color)
                                    <option value="{{ $color->id }}" @if(@$show && (@$pivot->batch->color->id == @$color->id)) selected @endif>
                                        {{ $color->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group form-row align-items-center">
                                {{-- <label for="qty" class="col-form-label col-12">Jumlah</label> --}}
                                <div class="col-9 col-lg-2">
                                    <input type="number" name="batches[0][qty]" id="qty" class="form-control" min="0" value="{{ @$show || @$startOrder ? $pivot->batch->qty : 1 }}" {{ @$show || @$startOrder ? 'disabled' : '' }}>
                                </div>
                                <div class="col-3">
                                    Kilogram
                                </div>
                            </div>
                        </div>
                        <div class="col-1 text-center">
                        </div>
                    </div>

                    <div id="batches"></div>

                    <div class="row">
                        <div class="col-12">
                            <button type="button" id="tambah-batch" class="btn btn-light btn-block float-right"><i class="fa fa-plus fa-sm"></i> Tambah Batch</button>
                        </div>
                    </div>


                    <div class="form-group row">
                        @if(@$show)
                        <label for="qty" class="col-form-label col-12">Jumlah Setelah Error (Kg)</label>
                        <div class="col-4">
                            <input type="number" name="qty" id="qty" class="form-control" min="0" value="{{ @$show || @$startOrder ? $pivot->actual_qty : 1 }}" {{ @$show || @$startOrder ? 'disabled' : '' }}>
                        </div>
                        @else
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary mt-5">Tambahkan Order Baru</button>
                        </div>
                        @endif
                    </div>

                    @else
                    <div class="form-row">
                        <div class="col-1">
                            <p>#{{ $pivot->batch->id }}</p>
                        </div>
                        <div class="col-10">
                            <div class="form-group">
                                {{-- <label for="colors">Warna</label> --}}
                                <select class="form-control" name="batches[0][color]" id="colors" disabled>
                                    <option value="" selected disabled>- Pilih Warna -</option>
                                    @foreach($colors as $color)
                                    <option value="{{ $color->id }}" @if((@$pivot->batch->color->id == @$color->id)) selected @endif>
                                        {{ $color->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group form-row align-items-center">
                                {{-- <label for="qty" class="col-form-label col-12">Jumlah</label> --}}
                                <div class="col-9 col-lg-2">
                                    <input type="number" name="batches[0][qty]" id="qty" class="form-control" min="0" value="{{ @$show || @$startOrder ? $pivot->batch->qty : 1 }}" {{ @$show || @$startOrder ? 'disabled' : '' }}>
                                </div>
                                <div class="col-3">
                                    Kilogram
                                </div>
                            </div>
                        </div>
                        <div class="col-1 text-center">
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection