<div class="row my-3">
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
        <div id="chart" style="height: 300px;"></div>
    </div>
</div>

@push('js')
    <!-- Charting library -->
    <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
    <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "@chart('grade_pie_chart')",
            hooks: new ChartisanHooks()
                .datasets('pie')
                .pieColors(['#4CAF50', '#FFEB3B', '#f44336'])
        });
    </script>
@endpush
