<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Customer;
use App\Models\Commission;
use App\Models\MainProject;
use App\Models\Construction;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commissionsa = Commission::all();
        if (count($commissionsa) < 1) {
        return view('admins.commissions.index', ['commissions'=>$commissionsa]);
        }
        foreach ($commissionsa as $commission) {
            $unit = Unit::find($commission->unit_id);
            $commissions[] = array(
                "id"               => $commission->id,
                "customer"         => Customer::find($commission->customer_id),
                "unit"             => $unit,
                "construction"     => Construction::find($unit->construction_id),
                "mainProject"      => MainProject::find($unit->main_project_id),
                "percentage"       => $commission->percentage,
                "commission_value" => $commission->commission_value,
            );
        }
        // dd($commissions);
        return view('admins.commissions.index', ['commissions'=>$commissions]);
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
        $unit = Unit::find($request->input('unit_id'));
        $commission = new Commission();
        if (empty($request->input('customer_id'))) {
            return back()->with('none', 'اختر العميل البائع');
        }
        $commission->customer_id      = $request->input('customer_id');
        $commission->user_id          = $request->input('user_id');
        $commission->unit_id          = $request->input('unit_id');
        $commission->percentage       = $request->input('percentage');
        $commission->commission_value = $unit->unit_price * $commission->percentage / 100;
        $commission->save();
        return redirect()->route('commissions.index')->with('success', 'Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show(Commission $commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commission $commission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        //
    }
}
