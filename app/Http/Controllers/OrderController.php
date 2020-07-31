<?php

namespace App\Http\Controllers;

use App\Color;
use App\Counter;
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
        // dd(OrderUser::where('step', Auth::user()->id_category)->get());

        return view('order.index', [
            // 'orders' => Order::mine()->unfinished()->latest()->get(),
            'orders' => OrderUser::with('order')->where([
                'step' => Auth::user()->id_category,
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
        return view('order.form', [
            'order' => Order::find($id),
            'show' => TRUE,
            'items' => Item::all(),
            'sales' => Sales::all(),
            'colors' => Color::all(),
            'today' => CarbonImmutable::today()
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

        $pivot->user_id = Auth::id();

        $pivot->save();

        return redirect()->route('orders.index')->with('info', 'Order #' . $pivot->order->no_so . ' telah dimulai untuk proses ini.');
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
        $order = Order::find($id);

        $order->users()->updateExistingPivot(Auth::id(), ['grade' => $request->grade]);

        $nextStep = Auth::user()->category->id += 1;

        // if ($nextStep < 5) {
        OrderUser::create([
            'order_id' => $order->id,
            'step' => $nextStep
        ]);
        // }

        return redirect()->route('orders.index')->with('info', 'Order #' . $order->no_so . ' telah ditandai selesai untuk proses ini.');
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
