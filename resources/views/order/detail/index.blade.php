@extends('layouts.admin')

@section('title')
    Batch Order #{{$batch->order->no_so}}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h4>Batch {{$batch->color->name}}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card my-3">
                <div class="card-body">
                    <span class="font-weight-bold">
                        Proses Batch
                    </span>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Proses</th>
                        <th>PIC</th>
                        <th>Diproses</th>
                        <th>Grade</th>
                        <th>Error</th>
                        <th>Hasil</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($batch->process as $process)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $process->created_at->toFormattedDateString() }}</td>
                            <td>{{ App\OrderUser::step($process->step) }}</td>
                            <td>{{ $process->user->name ?? '-' }}</td>
                            <td>{{ $process->processed }} Kg</td>
                            <td>{{ $process->grade ?? '-' }}</td>
                            <td>{{ $process->error }} Kg</td>
                            <td>{{ $process->processed - $process->error }} Kg</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Tidak ada proses sebelumnya.</td>
                        </tr>
                    @endforelse
                    </tbody>
{{--                    <tfoot>--}}
{{--                    <tr>--}}
{{--                        <td colspan="7" class="text-right">Qty Batch:</td>--}}
{{--                        <td>{{ $process->batch->qty }} Kg</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td colspan="5" class="text-right">Total Diproses:</td>--}}
{{--                        <td>{{ $process->current_step_processed }} Kg</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td colspan="7" class="text-right">Total Error:</td>--}}
{{--                        <td>{{ $process->total_errors }} Kg</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td colspan="7" class="text-right"><strong>Sisa Qty:</strong></td>--}}
{{--                        <td><b>{{ $process->qty_after_errors }} Kg</b></td>--}}
{{--                    </tr>--}}
{{--                    </tfoot>--}}
                </table>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="text-center">
                                <p>Qty Awal</p>
                                <h3>{{$batch->qty}} Kg</h3>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="text-center">
                                <p>Total Error</p>
                                <h3>{{$process->total_errors}} Kg</h3>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="text-center">
                                <p>Qty Akhir</p>
                                <h3>{{$process->qty_after_errors}} Kg</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
