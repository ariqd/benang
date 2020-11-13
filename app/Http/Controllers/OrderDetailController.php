<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Order;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index($id)
    {
        return view('order.detail.index', [
            'batch' => Batch::with('process')->find($id)
        ]);
    }
}
