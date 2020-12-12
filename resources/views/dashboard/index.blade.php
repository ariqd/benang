<div class="row my-3 pt-3">
    <div class="col-md-6">
        <h4>Grade Barang Pada Periode</h4>
    </div>
    <div class="col-md-6">
        <form class="form-inline float-right" method="GET">
            <label class="my-1 mr-2" for="m">Periode:</label>

            <select class="custom-select my-1 mr-sm-2" id="m" name="m">
                @foreach($months as $month)
                    <option value="{{ $loop->iteration }}" {{ $loop->iteration == $month_today ? 'selected' : '' }}>
                        {{ $month }}
                    </option>
                @endforeach
            </select>

            <select class="custom-select my-1 mr-sm-2" id="y" name="y">
                @for($year = date('Y'); $year >= 2019; $year--)
                    <option value="{{ $year }}" {{ $year == $year_today ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>

            <button type="submit" class="btn btn-primary btn-sm my-1">Cari</button>
            <a href="{{ url('/') }}" class="btn btn-link btn-sm my-1">Reset</a>
        </form>
    </div>
</div>

<div class="row my-3">
    <div class="col-md-6">
        <h5 class="text-center">Total Grade Barang Produksi (dalam %)</h5>
        {{-- <div id="chart" style="height: 300px;"></div> --}}
        <div class="w-100">
            {!! $pie_grade->container() !!}
        </div>
    </div>
    <div class="col-md-6">
        <h5 class="text-center">Jumlah Order Mengalami Keterlambatan (dalam %)</h5>
        <div class="w-100">
            {!! $bar_late->container() !!}
        </div>
    </div>
</div>

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $pie_grade->script() !!}
    {!! $bar_late->script() !!}
@endpush
