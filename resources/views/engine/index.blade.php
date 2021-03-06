@extends('layouts.admin')

@section('title')
Mesin {{ auth()->user()->category->name }}
@endsection

@section('content')
<div class="row">
    {{-- <div class="col-md-12">
        <p class="font-weight-bold">
            Total Kapasitas = {{ $total_capacity }} Kg | Digunakan = 100 Kg | Tersisa = 100 Kg
        </p>
    </div> --}}

    @forelse($engines as $engine)
        <div class="col-md-2 my-2">
            <div class="card h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                    <h3 class="text-dark">{{ $engine->name }}</h3>
                    <h5 class="text-gray-500 m-0">{{ $engine->usage->where('active', TRUE)->sum('qty') }} Kg / {{ $engine->capacity }} Kg</h5>
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-2 my-2">
            No data.
        </div>
    @endforelse
</div>
@endsection
