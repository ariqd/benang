<?php

namespace App\Http\Controllers;

use App\Item;
use App\Batch;
use App\Color;
use App\Order;
use App\Sales;
use App\Engine;
use App\Counter;
use App\OrderUser;
use App\EngineOrderUser;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Repository\Dashboard;
//use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        if (Auth::user()->isManager() || Auth::user()->isPpic()) {
            $ongoing = Batch::where('status', 'ONGOING')->get();

            foreach ($ongoing as $batch) {
                if (CarbonImmutable::today() >= $batch->order->created_at->addDays(12)) {
                    $batch->status = 'LATE';

                    $batch->save();
                }
            }

            return view('order.orders', [
                'batches' => Batch::with('order')->latest()->get(),
                'today' => CarbonImmutable::today(),
                'months' => Dashboard::MONTHS,
                'month_today' => request()->get('m') ?: date('n'),
                'year_today' => request()->get('y') ?: date('Y'),
            ]);
        } else {
            $orders = OrderUser::where([
                'step' => Auth::user()->category_id,
                'grade' => null,
            ])
                ->where('step', Auth::user()->category_id)
//                ->whereBetween('created_at', [function ($query) {
//                    $query->select('created_at');
//                }, $today->addDays(20)])
                ->orderBy('batch_id')
                ->latest()
                ->get();
        }

        return view('order.index', [
            'orders' => $orders,
            'today' => CarbonImmutable::today(),
            'months' => Dashboard::MONTHS,
            'month_today' => request()->get('m') ?: date('n'),
            'year_today' => request()->get('y') ?: date('Y'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $counter = Counter::where("name", "=", "SO")->first();

        return view('order.form', [
            'show' => FALSE,
            'items' => Item::all(),
            'sales' => Sales::orderBy('name')->get(),
            'colors' => Color::all(),
            'today' => CarbonImmutable::today(),
            'mulaiProduksi' => false,
            'no_so' => "SO" . date("ymd") . str_pad(Auth::id(), 2, 0, STR_PAD_LEFT) . str_pad($counter->counter, 5, 0, STR_PAD_LEFT)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $order = Order::create([
            'sales_id' => $input['sales_id'],
            'no_so' => $input['no_so'],
            'item_id' => $input['item_id'],
        ]);

        if (!$order) {
            return redirect()->route('orders.create')->with('error', 'Order gagal ditambahkan.');
        } else {
            $counter = Counter::where("name", "=", "SO")->first();
            $counter->counter += 1;
            $counter->save();

            foreach ($input['batches'] as $batch) {
                $batch_to_be_processed = Batch::create([
                    'order_id' => $order->id,
                    'color_id' => $batch['color'],
                    'qty' => $batch['qty'],
                ]);

                OrderUser::create([
                    'batch_id' => $batch_to_be_processed->id,
                    'step' => Order::STEP_SOFTWINDING
                ]);
            }

            return redirect()->route('orders.index')->with('info', 'Order berhasil ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pivot = OrderUser::find($id);

        $pivots = OrderUser::where([
            ['batch_id', '=', $pivot->batch_id],
            ['grade', '!=', NULL],
        ])->orderBy('step')->get();

        $actual_qty = $pivot->batch->qty - $pivots->sum('error');

        if ($pivots->count() > 0) {
            $actual_qty -= ($pivot->usage->sum('qty') - $pivot->processed);
        }

        return view('order.form', [
            'pivot' => $pivot,
            'show' => TRUE,
            'items' => Item::all(),
            'sales' => Sales::all(),
            'colors' => Color::all(),
            'today' => CarbonImmutable::today(),
            'pivots' => $pivots,
            'actual_qty' => $actual_qty,
            'startOrder' => false,
            'mulaiProduksi' => false
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pivot = OrderUser::find($id);

        $pivots = OrderUser::where([
            ['batch_id', '=', $pivot->batch_id],
            ['grade', '!=', NULL],
        ])->orderBy('step')->get();

        $actual_qty = $pivot->batch->qty - $pivots->sum('error');

        if ($pivots->count() > 0 && $pivot->usage) {
            $actual_qty -= ($pivot->usage->sum('qty') - $pivot->processed);
        }

        return view('order.form', [
            'pivot' => $pivot,
            'show' => FALSE,
            'startOrder' => TRUE,
            'items' => Item::all(),
            'sales' => Sales::all(),
            'colors' => Color::all(),
            'today' => CarbonImmutable::today(),
            'pivots' => $pivots,
            'actual_qty' => $actual_qty,
            'engines' => Engine::where('category_id', auth()->user()->category_id)->get(),
            'mulaiProduksi' => true
        ]);
    }

    public function startOrder(Request $request, $id)
    {
        $input = $request->all();
        $pivot = OrderUser::find($id);

        $to_be_processed = 0;
        foreach ($input['process_qty'] as $id => $process) {
            $to_be_processed += $process;
        }

        if ($to_be_processed > $request->qty) {
            return redirect()->back()->withInput()->with('error', 'Jumlah Qty Produksi lebih besar dari Qty Order ini!');
        }

        $pivot->processed += $to_be_processed;

        $pivot->user_id = Auth::id();

        $pivot->save();

        foreach ($input['process_qty'] as $id => $qty) {
            if ($qty > 0) {
                EngineOrderUser::create([
                    'process_id' => $pivot->id,
                    'engine_id' => $id,
                    'qty' => $qty
                ]);
            }
        }

        return redirect()->route('orders.index')->with('info', 'Order #' . $pivot->batch->order->no_so . ' telah dimulai untuk proses ini.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pivot = OrderUser::find($id);

        $nextStep = Auth::user()->category->id;

        if ($pivot->current_step_processed >= $pivot->qty_after_errors) {
            $nextStep += 1;
        }

        $pivot->grade = $request->grade;
        $pivot->error = $request->error ?? 0;
        $pivot->save();

        if ($nextStep <= Order::STEP_PACKING) {
            OrderUser::create([
                'batch_id' => $pivot->batch->id,
                'step' => $nextStep
            ]);

            EngineOrderUser::where('process_id', $pivot->id)->update(['active' => FALSE]);
        }

        return redirect()
            ->route('orders.index')
            ->with('info', 'Batch Order #' . $pivot->batch->order->no_so . ' telah ditandai selesai.');
    }
}
