<?php

declare(strict_types = 1);

namespace App\Charts;

use App\OrderUser;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradePieChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $data = OrderUser::select('grade', DB::raw('count(*) as total'))->whereNotNull('grade')->groupBy('grade')->get()->groupBy('grade')->toArray();

        return Chartisan::build()
            ->labels(['A', 'B', 'C'])
            ->dataset('Sample', [$data['A'][0]['total'] ?? 0, $data['B'][0]['total'] ?? 0, $data['C'][0]['total'] ?? 0]);
//            ->dataset('Sample 2', [3, 2, 1]);
    }
}
