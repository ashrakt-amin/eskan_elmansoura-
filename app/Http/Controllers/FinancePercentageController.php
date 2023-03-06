<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Finance;
use App\Models\Payment;
use App\Models\PaymentKind;
use Illuminate\Http\Request;
use App\Models\FinancePercentage;

class FinancePercentageController extends Controller
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
    public function index()
    {
        $financePercentages = FinancePercentage::all();
        return view('admins.financePercentages.index', compact('financePercentages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $finances  = Finance::all();
        return view('admins.financePercentages.create', ['finances'=>$finances]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exists = FinancePercentage::where([['unit_id', $request->unit_id], ['payment_kind_id', $request->payment_kind_id]])->get();

        if (count($exists) > 0 ) {
            return back()->with('none', 'none');
        }

        foreach ($request->unit_id as $key => $value) {

            $financePercentage = new FinancePercentage();

            $financePercentage->unit_id                 = $value;
            $financePercentage->payment_kind_id         = $request->payment_kind_id[$key];
            $financePercentage->payment_kind_percentage = $request->payment_kind_percentage[$key];
            if (!empty($request->payment_kind_value[$key])) {
                $financePercentage->payment_kind_value      = $request->payment_kind_value[$key];
                $financePercentage->payment_kind_percentage = ($financePercentage->payment_kind_value / $request->unit_price[$key] * 100);
            } else {
                if (!empty($financePercentage->payment_kind_percentage)) {
                    $financePercentage->payment_kind_value = ($request->unit_price[$key] * $financePercentage->payment_kind_percentage) / 100;
                }
                //  else {
                //     return back()->with('none', 'يجب اختيار النسبة او القيمة');
                // }
            }
            $financePercentage->due_date                = $request->due_date[$key];
            if (!empty($financePercentage->payment_kind_value) && !empty($financePercentage->payment_kind_percentage)) {
                $financePercentage->save();
            }

        }
        $unit = Unit::find($financePercentage->unit_id);
        $finance_percentage = FinancePercentage::orderBy('payment_kind_id', 'ASC')->where('unit_id', $unit->id)->first();
        if (!empty($finance_percentage->due_date)) {
            $unit->created_at = $finance_percentage->due_date.' '.date('H:i:s');
            $unit->update();
        }
        if ($financePercentage->id > 0) {
            return back()->with('success', 'تم اضافة النسبة بنجاح');
        } else {
            return back()->with('success', ' لم يتم حفظ القيم الفارغة ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $financePercentage  = FinancePercentage::find($id);

        $financePercentages = FinancePercentage::where('unit_id', $financePercentage->unit_id)->get();

        return view('admins.financePercentages.show', compact('financePercentages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $finance_percentage = FinancePercentage::find($id);
        $unit = Unit::find($finance_percentage->unit_id);

        return view('admins.financePercentages.edit', compact('finance_percentage', 'unit'));
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
        $financePercentage = FinancePercentage::find($id);

        $financePercentage->payment_kind_id         = $request->input('payment_kind_id');
        $financePercentage->payment_kind_percentage = $request->input('payment_kind_percentage');
        if (!empty($request->input('payment_kind_value'))) {
            $financePercentage->payment_kind_value      = $request->input('payment_kind_value');
            $financePercentage->payment_kind_percentage = ($financePercentage->payment_kind_value / $request->input('unit_price') * 100);
        } else {
            if (!empty($financePercentage->payment_kind_percentage)) {
                $financePercentage->payment_kind_value = ($request->input('unit_price') * $financePercentage->payment_kind_percentage) / 100;
            }
        }

        if (empty($request->input('due_date'))) {
            $financePercentage->due_date  = $request->input('finance_percentage_due_date');
        } else {
            $financePercentage->due_date  = $request->input('due_date');
        }

        $financePercentage->update();
        return redirect()->route('unitShow', ['id'=>$request->input('unit_id')])->with('warning', 'تم تعديل ميعاد بيانات الاستحقاق');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $financePercentage = FinancePercentage::find($id);

        if ($id == 'all') {
            $financePercentages = FinancePercentage::where('unit_id', $_GET['unit_id'])->get();
            foreach ($financePercentages as $financePercentage) {
                $financePercentage->delete();
            }
            return back()->with('success', 'تم حذف كل مواعيد الاستحقاق');
        } else {
            $financePercentage->delete();
        }
        return back()->with('success', 'تم حذف ميعاد الاستحقاق');
    }
}
