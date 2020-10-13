<div class="row mt-4">
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

<div class="row">
    <div class="col-md-6">
        
    </div>
</div>
