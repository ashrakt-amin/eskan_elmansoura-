<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Finance;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Installment;
use App\Models\Residual;
use Illuminate\Http\Request;

class InstallmentController extends Controller
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
        $installments = Installment::all();
        $residuals    = Residual::all();
        return view('admins.installmentsIndex', compact('installments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $units     = Unit::all();
        $customers = Customer::all();
        $finances  = Finance::all();
        $payments  = Payment::all();

        return view('admins.installments.addInstallment', compact('units', 'customers', 'finances', 'payments'));
    }

    public function existsInstallmentMonth()
    {
        return '<h1>تم الدفع من قبل</h1><h1>او</h1><h1>ان احد المدخلات فارغة</h1><h1>او</h1><h1>ان العميل لم يكمل الدفعات الاساسية</h1>';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $installment = new Installment();
        $installment->unit_id            = $request->input('unit_id');
        $installment->customer_id        = $request->input('customer_id');
        if (!empty($request->input('created_at'))) {
            $installment->created_at         = $request->input('created_at')." ".date("H:i:s");
        }

        $unit_payments = Payment::select('payment_kind_id')->where([['unit_id', $installment->unit_id], ['customer_id', $installment->customer_id]])->get();
        foreach ($unit_payments as $unit_payment) {
            $payments_array[] = $unit_payment->payment_kind_id;
        }

        $exist_installment_month = Installment::select('installment_month')->where([['unit_id', $installment->unit_id], ['customer_id', $installment->customer_id]])->get();
        $month   = $request->input('month');
        $year   = $request->input('year');
        $installment->installment_month  = $month.'-'.$year;

            foreach ($exist_installment_month as $exist_installment) {
                if ($installment->installment_month == $exist_installment->installment_month) {
                    return redirect('/unitShow/'.$installment->unit_id )->with('status', 'تم دفع قسط شهر'.$installment->installment_month.'من قبل ');
                }
            }
            if (!$month && !$year) {
                $installment->installment_month  = $request->input('installment_month');
            }

            if ($month && !$year) {
                return redirect('/unitShow/'.$installment->unit_id )->with('status', 'ادخل العام ');
            } elseif (!$month && $year) {
                return redirect('/unitShow/'.$installment->unit_id )->with('status', 'ادخل الشهر ');
            }

            if (empty($request->input('installment_value'))) {
                return redirect('/unitShow/'.$installment->unit_id )->with('status', ' ادخل قيمة القسط ');
            } else {
                $installment->installment_value  = $request->input('installment_value');
            }

            $installments_count = $installment->unit->installments_count;
            if ($installments_count < 1) {
                return back()->with('warning', 'يرجى ادخال عدد الاقساط اولا');
            }

            $last_installment = Installment::orderBy('id', 'desc')->where([['unit_id', $installment->unit_id], ['customer_id', $installment->customer_id]])->first();

            if (!empty($last_installment)) {
                $installment->residual_installments = $last_installment->residual_installments - 1 ;
            }else {
                $installment->residual_installments = $installments_count - 1 ;
            }

            if (empty($installment->cancellation_code) || $installment->cancellation_code == null ) {
                $installment->cancellation_code = 0;
            } else {
            $installment->cancellation_code  = $request->input('cancellation_code');
            }

            if (empty($installment->installment_recovery) || $installment->installment_recovery == null ) {
                $installment->installment_recovery = 0;
            } else {
            $installment->installment_recovery  = $request->input('installment_recovery');
            }


        $residuals  = Residual::select()->where([['unit_id', $installment->unit_id], ['customer_id', $installment->customer_id]])->get();

        if (count($residuals) > 0 ) {
            foreach ($residuals as $item) {
            }
            $residual      = $installment->unit->unit_price - $item->all_payments - $installment->installment_value;
            if ($item->all_residuals == 0) {
                return back()->with('success', 'لقد انهى العميل كل مديونيات هذه الوحدة');
            } elseif ($residual < 0) {
                return back()->with('danger', 'المبلغ المتبقي اقل من المبلغ المدفوع');
            }
        }
        $installment->save();

        // STORE IN RESIDUAL TABLE
        // STORE IN RESIDUAL TABLE
        // STORE IN RESIDUAL TABLE

        $residual = new Residual();

        $residual->unit_id           = $installment->unit_id;
        $residual->customer_id       = $installment->customer_id;
        $residual->installment_id    = $installment->id;
        $residual->unit_price        = $installment->unit->unit_price;
        $residual->cancellation_code = $installment->cancellation_code;


        $lastResidual  = Residual::orderBy('id', 'desc')->where([['unit_id', $installment->unit_id], ['customer_id', $installment->customer_id]])->first();
        if (!empty($lastResidual) ) {
            $residual->all_payments    = $installment->installment_value + $lastResidual->all_payments;
            $residual->all_recoveries  = $installment->installment_recovery + $lastResidual->all_recoveries;
        } else {
            $residual->all_payments      = $installment->installment_value;
            $residual->all_recoveries  = $installment->installment_recovery;
        }
        $residual->all_residuals          = $residual->unit_price - $residual->all_payments + $residual->all_recoveries;

        $residual->save();
        // # STORE IN RESIDUAL TABLE
        // # STORE IN RESIDUAL TABLE
        // # STORE IN RESIDUAL TABLE
        if ($residual->all_residuals == 0) {
            return back()->with('success', 'لقد انهى العميل كل مديونيات هذه الوحدة');
        }
        return back()->with('success', 'تم اضافة قسطا جديدا');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $Installment = Installment::with('customers', 'unit', 'constructions', 'property','mainProjects')->find($id);
        // $customer_id = $customers->id;
        // $units = Unit::select()->where('customer_id', $customer_id)->get();

        // return view('admins.constructions.showConstruction', compact('Installment', 'units'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $installment  = Installment::find($id);
        return view('admins.installments.editInstallment', compact('installment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $unit_id              = $request->input('unit_id');
        $customer_id          = $request->input('customer_id');
        $installment_month    = $request->input('installment_month');
        $month                = $request->input('month');
        $year                 = $request->input('year');

        $unitInstallments  = Installment::where([['unit_id', $unit_id] ,['customer_id', $customer_id]])->get();
        foreach ($unitInstallments as $unitInstallment) {
            $installmentMonthes[] = $unitInstallment->installment_month;
        }

        $installment = Installment::find($id);
        $recentValue = $installment->installment_value;
        if (!empty($month)) {
            $installment->installment_month  = $month.'-'.$year;
        } else {
            $installment->installment_month  = $installment_month;
        }
        if (!empty($request->input('created_at'))) {
            $installment->created_at         = $request->input('created_at')." ".date("H:i:s");
        }
        if (!empty($request->input('installment_value'))) {
            $installment->installment_value = $request->input('installment_value');
            $installment->update();

            // update residual data
            $thisResidual   = Residual::where('installment_id', $installment->id)->first();
            $residualBefore = Residual::orderBy('id', 'DESC')->where([['unit_id' , $installment->unit_id], ['customer_id' , $installment->customer_id], ['id', '<', $thisResidual->id]])->first();
            $thisResidual->all_payments = $residualBefore->all_payments + $request->input('installment_value');
            $thisResidual->all_residuals = $residualBefore->all_residuals - $request->input('installment_value');
            $thisResidual->update();

            // update all next residuals
            $residuals = Residual::where([['unit_id', $unit_id], ['customer_id', $customer_id], ['id', '>', $thisResidual->id]])->get();
            if (count($residuals) > 0) {
                foreach ($residuals as $residual) {
                    $residualBefore = Residual::orderBy('id', 'DESC')->where([['unit_id' , $installment->unit_id], ['customer_id' , $installment->customer_id], ['id', '<', $residual->id]])->first();
                    $residual->all_payments = $residualBefore->all_payments + $request->input('installment_value');
                    $residual->all_residuals = $residualBefore->all_residuals - $request->input('installment_value');
                    $residual->update();
                    // dd($residualBefore->all_payments, $request->input('installment_value'), $residualBefore->all_residuals, $thisResidual->all_residuals);
                }
            }
        }

        return redirect()->route('unitShow', ['id'=>$installment->unit_id])->with('success', 'تم تعديل الدفعة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Installment $installment)
    {
        $recentValue  = $installment->installment_value;
        $id           = $installment->id;

        if ($installment->delete()) {
            $installments = Installment::where([['unit_id', $installment->unit_id], ['customer_id', $installment->customer_id], ['id', '>', $id]])->get();
            foreach ($installments as $installment) {
                $installment->residual_installments =  $installment->residual_installments + 1 ;
                $installment->update();
            }
            $thisResidual = Residual::where('installment_id', $id)->first();
            $thisResidualId = $thisResidual->id;
            $thisResidual->delete();

            $residuals  = Residual::where([['unit_id', $installment->unit_id], ['customer_id', $installment->customer_id], ['id', '>', $thisResidualId]])->get();
            if (count($residuals) > 0) {
                foreach ($residuals as $residual) {
                    $residual->all_payments  = $residual->all_payments - $recentValue;
                    $residual->all_residuals = $residual->all_residuals + $recentValue;
                    $residual->update();
                }
            }

            return back()->with('success', 'تم حذف القسط');
        } else {
            return back()->with('none', 'فشل الحذف');
        }
    }
}
