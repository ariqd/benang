<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Charts\BarUsage;
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

        $labelsLineError = $datasetLineError = [];

        foreach ($process as $pivot) {
            $labelsLineError[] = $pivot[0]->user->username;
            $datasetLineError[] = $pivot->sum('error');
        }

        $lineError->labels(collect($labelsLineError)->map(function ($username) {
            return ucwords($username);
        }));

        $lineError->dataset('Jumlah Barang Error (Kg)', 'bar', $datasetLineError)
            ->color('#2196F3')
            ->backgroundColor('#B3E5FC');

        // Bar Chart Penggunaan Mesin
        $barUsage = new BarUsage;

        $labelsBarUsage = $datasetBarUsage = [];

        foreach ($batch->process as $pivot) {
            foreach ($pivot->usage as $usage) {
                $labelsBarUsage[] = $pivot->user->category->name . " " . $usage->engine->name;
                $datasetBarUsage[] = $usage->qty;
            }
        }

        $barUsage->labels($labelsBarUsage);

        $barUsage->dataset('Penggunaan Mesin (Kg)', 'bar', $datasetBarUsage)
            ->color('#6D4C41')
            ->backgroundColor('#8D6E63');

        return view('order.detail.index', [
            'batch' => $batch,
            'line_error' => $lineError,
            'bar_usage' => $barUsage
        ]);
    }
}
