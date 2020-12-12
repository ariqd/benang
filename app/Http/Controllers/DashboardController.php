<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Charts\BarLateOrders;
use App\Charts\PieGrade;
use App\Order;
use App\OrderUser;
use App\Repository\Dashboard;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $ongoing = Order::where('status', 'ONGOING')->get();

        foreach ($ongoing as $order) {
            if (CarbonImmutable::today() >= $order->created_at->addDays(12)) {
                $order->status = 'LATE';
                $order->save();

                foreach ($order->batch as $batches) {
                    $batches->status = 'LATE';
                    $batches->save();
                }
            }
        }

        $year_to = request()->get('y') ?: date('Y');
        $month_to = request()->get('m') ?: date('n');

        $grades = OrderUser::select('grade', DB::raw('count(*) as total'))
            ->whereYear('created_at', $year_to)
            ->whereMonth('created_at', $month_to)
            ->whereNotNull('grade')
            ->groupBy('grade')
            ->get();

        $gradeA = isset($grades->groupBy('status')
                ->toArray()['LATE']) ? round($grades->groupBy('grade')
                ->toArray()['A'][0]['total'] / $grades->sum('total') * 100, 2) : 0;

        $gradeB = isset($grades->groupBy('status')
                ->toArray()['LATE']) ? round($grades->groupBy('grade')
                ->toArray()['B'][0]['total'] / $grades->sum('total') * 100, 2) : 0;

        $gradeC = isset($grades->groupBy('status')
                ->toArray()['LATE']) ? round($grades->groupBy('grade')
                ->toArray()['C'][0]['total'] / $grades->sum('total') * 100, 2) : 0;

        $pieGrade = new PieGrade;

        $pieGrade->dataset('Grade (dalam %)', 'pie', [$gradeA, $gradeB, $gradeC])
            ->backgroundColor(['#4CAF50', '#FF9800', '#f44336']);

        $lateOrders = Order::select('status', DB::raw('count(*) as total'))
            ->whereYear('created_at', $year_to)
            ->whereMonth('created_at', $month_to)
            ->groupBy('status')
            ->get();

        $late = isset($lateOrders->groupBy('status')
                ->toArray()['LATE']) ? round($lateOrders->groupBy('status')
                ->toArray()['LATE'][0]['total'] / $lateOrders->sum('total') * 100, 2) : 0;

        $done = isset($lateOrders->groupBy('status')
                ->toArray()['DONE']) ? round($lateOrders->groupBy('status')
                ->toArray()['DONE'][0]['total'] / $lateOrders->sum('total') * 100, 2) : 0;

        $barLateOrders = new BarLateOrders;

        $barLateOrders->dataset('Jumlah Order', 'pie', [$done ?? 0, $late ?? 0])
            ->backgroundColor('#2196F3');

        return view('order.orders', [
            'batches' => Batch::with('order')->latest()->get(),
            'today' => CarbonImmutable::today(),
            'months' => Dashboard::MONTHS,
            'month_today' => request()->get('m') ?: date('n'),
            'year_today' => request()->get('y') ?: date('Y'),
            'pie_grade' => $pieGrade,
            'bar_late' => $barLateOrders,
            'title' => 'Semua Batch Order'
        ]);
    }
}
