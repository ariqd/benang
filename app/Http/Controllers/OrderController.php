<?php

namespace App\Http\Controllers;

use App\Color;
use App\Counter;
use App\Engine;
use App\Item;
use App\Order;
use App\OrderUser;
use App\Sales;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order.index', [
            'orders' => OrderUser::with('batch')->where([
                'step' => Auth::user()->category_id,
                'grade' => null,
            ])->get(),
            'today' => CarbonImmutable::today()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $counter = Counter::where("name", "=", "SO")->first();

        return view('order.form', [
            'show' => FALSE,
            'items' => Item::all(),
            'sales' => Sales::all(),
            'colors' => Color::all(),
            'today' => CarbonImmutable::today(),
            'no_so' => "SO" . date("ymd") . str_pad(Auth::id(), 2, 0, STR_PAD_LEFT) . str_pad($counter->counter, 5, 0, STR_PAD_LEFT)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::create($request->all());

        if (!$order) {
            return redirect()->route('orders.create')->with('error', 'Order gagal ditambahkan.');
        }

        $counter = Counter::where("name", "=", "SO")->first();
        $counter->counter += 1;
        $counter->save();

        $order->users()->attach(Auth::user(), ['step' => Order::STEP_SOFTWINDING]);

        return redirect()->route('orders.index')->with('info', 'Order berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pivot = OrderUser::find($id);

        $pivots = OrderUser::where([
            ['batch_id', '=', $pivot->batch_id],
            ['grade', '!=', NULL],
        ])->orderBy('step')->get();

        $error_qty = $pivots->sum('error');

        return view('order.form', [
            'pivot' => $pivot,
            'show' => TRUE,
            'items' => Item::all(),
            'sales' => Sales::all(),
            'colors' => Color::all(),
            'today' => CarbonImmutable::today(),
            'pivots' => $pivots,
            'actual_qty' => $pivot->batch->qty - $error_qty,
            'startOrder' => false,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pivot = OrderUser::find($id);

        $pivots = OrderUser::where([
            ['batch_id', '=', $pivot->batch_id],
            ['grade', '!=', NULL],
        ])->orderBy('step')->get();

        $error_qty = $pivots->sum('error');

        return view('order.form', [
            'pivot' => $pivot,
            'show' => FALSE,
            'startOrder' => TRUE,
            'items' => Item::all(),
            'sales' => Sales::all(),
            'colors' => Color::all(),
            'today' => CarbonImmutable::today(),
            'pivots' => $pivots,
            'actual_qty' => $pivot->batch->qty - $error_qty,
            'engines' => Engine::where('category_id', auth()->user()->category_id)->get()
        ]);
    }

    public function startOrder(Request $request, $id)
    {
        $pivot = OrderUser::find($id);

        $pivot->user_id = Auth::id();

        $pivot->save();

        return redirect()->route('orders.index')->with('info', 'Order #' . $pivot->batch->order->no_so . ' telah dimulai untuk proses ini.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pivot = OrderUser::find($id);
        $pivot->grade = $request->grade;
        $pivot->error = $request->error;
        $pivot->save();

        $nextStep = Auth::user()->category->id += 1;

        OrderUser::create([
            'batch_id' => $pivot->batch->id,
            'step' => $nextStep
        ]);

        return redirect()
            ->route('orders.index')
            ->with('info', 'Order #' . $pivot->batch->order->no_so . ' telah ditandai selesai untuk proses ini.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
