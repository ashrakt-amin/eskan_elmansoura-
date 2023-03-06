<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Balance;
use App\Models\Payment;
use App\Models\Installment;
use App\Models\OverMuchUnit;
use Illuminate\Http\Request;

class OverMuchUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $overMuchUnits = OverMuchUnit::all();
        return view('admins.units.overMuchUnits.index', compact('overMuchUnits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $units        = Unit::where('main_project_id', $request->main_project_id)->get();
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

        $units_status_empty = Unit::where(['status'=>'خالية', 'main_project_id'=>$request->main_project_id])->get();
        foreach ($units_status_empty as $unit) {
            // $unit = Unit::find($unit->id);
            // $unit->over_much = $request->get('over_much');
            // $unit->update();
            $over_muche_unit = OverMuchUnit::orderBy('id', 'DESC')->where('unit_id', $unit->id)->first();
            $over_much = new OverMuchUnit();
            $over_much->unit_id         = $unit->id;
            $over_much->unit_name       = $unit->name;
            $over_much->main_project_id = $unit->main_project_id;
            $over_much->price_m         = !empty($over_muche_unit) ? $over_muche_unit->new_price_m : $unit->price_m;
            $over_much->over_much       = $request->get('over_much');
            $over_much->new_price_m     = $over_much->price_m + ($over_much->price_m * $over_much->over_much / 100);
            $over_much->unit_price      = $over_much->unit_price ? $over_much->unit_price : $unit->unit_price;
            $over_much->new_unit_price  = $over_much->new_price_m * $unit->space;
            $over_much->save();
        }
        $empty_units_prices        = OverMuchUnit::where(['main_project_id'=>$request->main_project_id])->sum('new_unit_price');

        $empty_over_much = $empty_units_prices * ($request->get('over_much') / 100);
        $units_prices = Unit::where('main_project_id', $request->main_project_id)->sum('unit_price');
        $balance = Balance::orderBy('id', 'DESC')->where(['main_project_id'=>$request->input('main_project_id')])->first();
        if (!$balance) {
            return back()->with('none', 'ادخل الميزانية المبدئية اولا');
        }
        $newBalance = new Balance();
        $newBalance->starting_balance = $balance->starting_balance;
        $newBalance->excepted_balance = $balance->excepted_balance;
        $newBalance->actual_balance   = $payments + $installments;
        $newBalance->current_balance  = $units_prices + $empty_units_prices * ($request->get('over_much') / 100);
        $newBalance->main_project_id  = $request->input('main_project_id');
        $newBalance->balance_code     = $balance->balance_code + 1 ;
        $newBalance->save();
        return back()->with('success', 'تم');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OverMuchUnit  $overMuchUnit
     * @return \Illuminate\Http\Response
     */
    public function show(OverMuchUnit $overMuchUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OverMuchUnit  $overMuchUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(OverMuchUnit $overMuchUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OverMuchUnit  $overMuchUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OverMuchUnit $overMuchUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OverMuchUnit  $overMuchUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(OverMuchUnit $overMuchUnit)
    {
        //
    }
}
