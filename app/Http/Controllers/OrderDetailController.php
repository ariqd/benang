<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Charts\LineError;

//use App\Order;
use App\OrderUser;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index($id)
    {
        $batch = Batch::with('process')->find($id);

        $lineError = new LineError;

        $process = $batch->process->whereNotNull('grade')->groupBy('step');

        $labels = $dataset = [];

        foreach ($process as $pivot) {
            $labels[] = $pivot[0]->user->username;
            $dataset[] = $pivot->sum('error');
        }

        $lineError->labels(collect($labels)->map(function ($username) {
            return ucwords($username);
        }));

        $lineError->dataset('Jumlah Barang Error (Kg)', 'bar', $dataset)
            ->color('#2196F3')
            ->backgroundColor('#B3E5FC');

        return view('order.detail.index', [
            'batch' => $batch,
            'line_error' => $lineError
        ]);
    }
}
