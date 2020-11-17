<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Order;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index($id)
    {
        $batch = Batch::with('process')->find($id);

//        dd($batch->process->groupBy('step')->toArray());

        return view('order.detail.index', [
            'batch' => $batch
        ]);
    }
}
