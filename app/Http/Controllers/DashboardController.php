<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Charts\BarLateOrders;
use App\Charts\PieGrade;
use App\Order;
use App\OrderUser;
use App\Repository\Dashboard;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

// use Illuminate\Http\Request;

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

//        $year_from = request()->get('y_from') ?: date('Y');
//        $month_from = request()->get('m_from') ?: date('n');

//        $date_to = CarbonImmutable::createFromDate($year_to, $month_to);
//        $date_from = CarbonImmutable::createFromDate($year_from, $month_from);

//        dd([
//            $year_from, $year_to, $month_from, $month_to
//        ]);

        $grades = OrderUser::select('grade', DB::raw('count(*) as total'))
            ->whereYear('created_at', $year_to)
            ->whereMonth('created_at', $month_to)
            ->whereNotNull('grade')
            ->groupBy('grade')
            ->get()
            ->groupBy('grade')
            ->toArray();

        $pieGrade = new PieGrade;

        $pieGrade->dataset('Grade', 'pie', [$grades['A'][0]['total'] ?? 0, $grades['B'][0]['total'] ?? 0, $grades['C'][0]['total'] ?? 0])
            ->backgroundColor(['#4CAF50', '#FF9800', '#f44336']);

        $lateOrders = Order
            ::select('status', DB::raw('count(*) as total'))
//            ->whereBetween('created_at', [CarbonImmutable::today()->subMonth()->startOfMonth(), CarbonImmutable::today()])
            ->whereYear('created_at', $year_to)
            ->whereMonth('created_at', $month_to)
            ->groupBy('status')
            ->get()->groupBy('status')
            ->toArray();

        $barLateOrders = new BarLateOrders;

        $barLateOrders->dataset('Jumlah Order', 'bar', [$lateOrders['DONE'][0]['total'] ?? 0, $lateOrders['LATE'][0]['total'] ?? 0])
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
