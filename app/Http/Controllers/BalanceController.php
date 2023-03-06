<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Balance;
use App\Models\Installment;
use App\Models\MainProject;
use App\Models\Payment;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MainProject $mainProject)
    {
        $balances = Balance::where('main_project_id', $mainProject->id)->get();
        return view('admins.balances.index', compact('balances', 'mainProject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(MainProject $mainProject)
    {
        $balance      = Balance::orderBy('id', 'desc')->where('main_project_id', $mainProject->id)->first();
        if (!$balance) {
            $balance_code = 0;
        } else {
            $balance_code = $balance->balance_code;
        }
        $units        = Unit::where('main_project_id', $mainProject->id)->get();
        foreach ($units as $unit) {
            $payments[]     = Payment::select('payment_value')->where('unit_id', $unit->id)->sum('payment_value');
            $installments[] = Installment::select('installment_value')->where('unit_id', $unit->id)->sum('installment_value');
        }
        if (!empty($payments)) {
            $payments     = array_sum($payments);
        } else {
            $payments     = 0;
        }
        if (!empty($installments)) {
            $installments = array_sum($installments);
        } else {
            $installments = 0;
        }
        return view('admins.balances.create', ['balance' => $balance, 'balance_code'=>$balance_code, 'units'=>$units, 'payments'=>$payments, 'installments'=>$installments, 'mainProject'=>$mainProject]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data=$request->all();
        // Balance::create($data);

        // or

        // Balance::create([
        //     'name'=>$request->name,
        //     'age'=>$request->age,
        // ]);

        //or

        $balance = new Balance();
        $balance->fill($request->input());
        $balance->save();
        return redirect()->route('show_main_project', ['id'=>$request->input('main_project_id')])->with('success', 'Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function show(Balance $balance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function edit(Balance $balance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Balance $balance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Balance $balance)
    {
        //
    }
}
