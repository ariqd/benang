@extends('layouts.admin')

@section('title')
Order List
@endsection

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

                Halaman ini masih dalam tahap pengembangan.
            </div>
        </div>
    </div>
</div>
@endsection