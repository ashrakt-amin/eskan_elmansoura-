<?php

namespace App\Http\Controllers;

use App\Models\FinancePercentage;
use App\Models\MainProject;
use App\Models\Payment;
use App\Models\PaymentKind;
use Illuminate\Http\Request;

class PaymentKindController extends Controller
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
        $paymentKinds = PaymentKind::all();

        return view('admins.paymentKindsIndex', compact('paymentKinds'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $main_projects = MainProject::all();
        return view('admins.payments.addPaymentKind', ['main_projects'=>$main_projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paymentkind = new PaymentKind();

        $paymentkind->name            = $request->input('name');
        $paymentkind->main_project_id = $request->input('main_project_id');
        $paymentkind->code            = $request->input('code');

        $paymentkinds = PaymentKind::where([['main_project_id', $request->input('main_project_id')], ['code', $request->input('code')]])->get();
        foreach ($paymentkinds as $paymentkind_stored) {
            $stored = $paymentkind_stored->name;
            if ($stored == $request->input('name')) {
                return back()->with('none', '"'.' مسجل من قبل  '.'"'.$stored);
            }
        }
        $paymentkind->save();

        return redirect('/paymentKindsIndex')->with('success', '"'.'تم اضافة دفعة '.'"'.$paymentkind->name);
    }

    //* Show the form for editing the specified resource.
    ////////////////////////////////////////////////
    public function edit($id)
    {
        $paymentKind = PaymentKind::find($id);
        $main_projects = MainProject::all();
        return view('admins.payments.editPaymentKind', compact('paymentKind', 'main_projects'));
    }
    ////////////////////////////////////////////////
    //* Update the specified resource in storage.
    ////////////////////////////////////////////////
    public function update(Request $request, $id)
    {

        $paymentkind = PaymentKind::find($id);

        $paymentkinds = PaymentKind::where([['id', '!=', $id], ['code', '0']])->get();
        foreach ($paymentkinds as $paymentkind_stored) {
            $stored = $paymentkind_stored->name;
            if ($stored == $request->input('name')) {
                return back()->with('none', '"'.' مسجل من قبل  '.'"'.$stored);
            }
        }

        $paymentkind->name            = $request->input('name');
        $paymentkind->main_project_id = $request->input('main_project_id');
        $paymentkind->code            = $request->input('code');

        $paymentkind->update();

        return redirect('paymentKindsIndex')->with('warning',  '"'.'تم تعديل الدفعة الى '.'"'.$paymentkind->name);
    }
    ////////////////////////////////////////////////

    //* Delete the specified resource in storage.
    ////////////////////////////////////////////////
    public function destroy($id)
    {
        $payments = Payment::select('id')->where('payment_kind_id', $id)->get();

            if (count($payments) > 0 ) {
                return back()->with('danger', 'يوجد مدفوعات تحت هذا الدفعة ولا يمكن حذفها');
            }

        $finance_percentages = FinancePercentage::where('payment_kind_id', $id)->get();
        if (count($finance_percentages) > 0 ) {
            return back()->with('danger', 'يوجد نسبة تحت هذا الدفعة ولا يمكن حذفها');
        }

        $paymentkind = PaymentKind::find($id);

        $paymentkind->delete();
        return redirect('/paymentKindsIndex')->with('success', 'تم حذف الدفعة');
    }
    ////////////////////////////////////////////////
}
