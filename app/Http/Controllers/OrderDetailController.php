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

        $labels = $dataset =  [];

        foreach ($process as $key => $pivot) {
//            dd($pivot->sum('error'));
            $labels[] = OrderUser::step($key);
            $dataset[] = $pivot->sum('error');
        }

//        dd($dataset);

        $lineError->labels($labels);

        $lineError->dataset('Jumlah Barang Error', 'line', $dataset)
            ->color('#2196F3')
            ->backgroundColor('#B3E5FC')
            ->lineTension(0);

        return view('order.detail.index', [
            'batch' => $batch,
            'line_error' => $lineError
        ]);
    }
}
