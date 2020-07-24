@extends('layouts.admin')

@section('title')
Mesin
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <p class="font-weight-bold">
            Total Kapasitas: {{ $total_capacity }} Kg
        </p>
    </div>

    <div class="col-md-2 my-2">
        <div class="card h-100">
            <a href="{{ url('engine/create') }}" class="text-decoration-none card-body text-center d-flex flex-column justify-content-center align-items-center">
                <i class="fa fa-plus my-3"></i>
                <h5>Tambah Mesin</h5>
            </a>
        </div>
    </div>

    @forelse($engines as $engine)
        <div class="col-md-2 my-2">
            <div class="card h-100">
                <a href="{{ url('engine/'.$engine->id.'/edit') }}" class="text-decoration-none card-body text-center d-flex flex-column justify-content-center align-items-center">
                    <h3 class="text-dark">{{ $engine->name }}</h3>
                    <h5 class="text-gray-500 m-0">{{ $engine->capacity }} Kg</h5>
                </a>
            <