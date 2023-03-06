<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Finance;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Residual;
use App\Models\Installment;
use App\Models\PaymentKind;
use Illuminate\Http\Request;
use App\Models\FinancePercentage;
use Illuminate\support\facades\DB;

class PaymentController extends Controller
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
        $payments      = Payment::all();

        return view('admins.paymentsIndex', compact('payments'));
    }

    public function search($day)
    {
        if ($day == 'today') {
            $todayPayments     = Payment::whereDate('created_at', date('Y-m-d'))->get();
            $todayInstallments = Installment::whereDate('created_at', date('Y-m-d'))->get();
            return view('admins.payments.search', compact('todayPayments', 'todayInstallments'));
        } elseif ($day == 'week') {
            $current_week      = Payment::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $installments_week = Installment::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            return view('admins.payments.search', compact('current_week', 'installments_week'));
        } elseif ($day == 'month') {
            $current_month      = Payment::whereMonth('created_at', date('m'))->get();
            $installments_month = Installment::whereMonth('created_at', date('m'))->get();
            return view('admins.payments.search', compact('current_month', 'installments_month'));
        }
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

        return view('admins.payments.addPayment', compact('units', 'customers', 'finances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUnitPayment(Request $request, $id)
    {

        $paymend_kinds     = new PaymentKind();

        if ($request->input('payment_kind_id') > 0) {
            $paymend_kinds->id = $request->input('payment_kind_id');
        } else {
            return back()->with('none', 'لم ينم اختيار دفعة');
        }
        $payment_kind     = PaymentKind::find($paymend_kinds->id );
        $payment_kind_percentage = $request->input('payment_kind_percentage');
        // dd($payment_kind_percentage);
        $units       = Unit::all();
        $unit        = Unit::find($id);
        $customer_id = Unit::select('customer_id')->where('id', $id)->get();
        $customer    = Customer::find($customer_id);
        $customers   = Customer::all();
        $finances    = Finance::all();
        $payments    = Payment::select()->where('unit_id', $id)->get();

        $financePercentageId = $_GET['payment_kind_id'];
        $financePercentages  = FinancePercentage::select()->where('id', $financePercentageId)->get();
        $financePercents     = FinancePercentage::all();
        $installments= Installment::select()->where('unit_id', $id)->get();

        // foreach ($payments as $payment) {
        //     $financeId = $payment->finance_id;
        //     if ($financeId) {
        //         if (!empty($financeId) || !is_null($financeId)) {
        //             return view('admins.payments.addUnitPayment', compact('units', 'unit', 'customer_id', 'customer','payments', 'financePercentages', 'customers', 'financeId', 'financePercents'));
        //         }
        //     }
        // }

        return view('admins.payments.addUnitPayment', compact('units', 'unit', 'customer_id', 'customer','payments', 'financePercentages', 'customers', 'finances', 'payment_kind', 'payment_kind_percentage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment = new Payment();

        $payment->unit_price         = $request->input('unit_price');
        $payment->finance_id         = $request->input('finance_id');
        $payment->payment_value      = $request->input('payment_value');
        $payment->installments       = $request->input('installments');
        $payment->installment_value  = $request->input('installment_value');
        $payment->customer_id        = $request->input('customer_id');
        $payment->unit_id            = $request->input('unit_id');
        $payment->property_id        = $request->input('property_id');
        $payment->main_project_id    = $request->input('main_project_id');
        $payment->construction_id    = $request->input('construction_id');
        $payment->level_id           = $request->input('level_id');

            $payment_value_before     = Payment::select()->where([['customer_id', $payment->customer_id], ['unit_id', $payment->unit_id]])->sum('payment_value');


            $allPayments = ($payment_value_before+$payment->payment_value);

        $payment->residual           = $payment->unit_price - $allPayments;
        $payment->discount           = $request->input('discount');
        $discount     = $payment->discount/100;
        $payment->cash_payment       = $request->input('cash_payment');
            if ($discount) {
                $payment->cash_discount  = $payment->residual - ($payment->residual * $discount);
            }

        return redirect('/paymentsIndex')->with('success', 'Payment added successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUnitPayment(Request $request)
    {
        $payment = new Payment();

        $payment->unit_id            = $request->input('unit_id');
        $payment->customer_id        = $request->input('customer_id');
        $payment->payment_kind_id    = $request->input('payment_kind_id');
        $payment->created_at         = $request->input('created_at');
        if (empty($request->input('payment_recovery')) || is_null($request->input('payment_recovery'))) {
            $payment->payment_recovery   = 0 ;
        } else {
            $payment->payment_recovery   = $request->input('payment_recovery');
        }
        $unitStatus = Unit::select('status')->where('id', $payment->unit_id)->get();
        foreach ($unitStatus as $status) {
            if ($status->status == 'خالية' || $status->status == 'محجوزة') {
                return redirect('unitShow/'.$payment->unit_id)->with('success', 'يرجى التعاقد اولا');
            }
        }
        //----- Start Check Duplicated payment kinds -----//
        $findPaymentKind = PaymentKind::find($payment->payment_kind_id);
        $code            = $findPaymentKind->code;
        if ($code == 0) {
        }

        $PaymentKindsId = Payment::select('payment_kind_id', 'payment_recovery')->where([['unit_id', $payment->unit_id], ['customer_id', $payment->customer_id]])->get();
        if ($PaymentKindsId->isNotEmpty() ) {
            foreach ($PaymentKindsId as $existsPaymentKind) {
                if ($payment->payment_recovery == 0) {
                    if ($existsPaymentKind->payment_kind_id == $payment->payment_kind_id) {
                        return back()->with('none', 'مدفوع من قبل');
                    }
                } elseif (empty($request->input('payment_recovery')) || is_null($request->input('payment_recovery'))) {
                    $payment->payment_recovery   = 0 ;
                } else {
                    $payment->payment_recovery   = $request->input('payment_recovery');
                }
            }
        } else {
            return back()->with('none', 'يرجى اختيار دفعة');
        }

        //----- End Check Duplicated payment kinds -----//
        $payment->payment_value      = $request->input('payment_value');
        $payment->cancellation_code  = $request->input('cancellation_code');
        if ($payment->cancellation_code !== ( 0 | 1) ) {
            $payment->cancellation_code = 0;
        }
            $beforePayments     = Payment::select()->where('unit_id', $payment->unit_id)->sum('payment_value');
            $existsPayments     = Payment::select('payment_kind_id')->where([['unit_id', $payment->unit_id], ['customer_id', $payment->customer_id]])->get();

            foreach ($existsPayments as $existsPayment) {
                $paymentArray = [];
                $paymentArray[] = $existsPayment->payment_kind_id;
                if (in_array($payment->payment_kind_id, $paymentArray) && $payment->payment_recovery == 0) {
                    return back()->with('success', 'مدفوع من قبل');
                }
            }

            $allPayments = $beforePayments + $payment->payment_value;
// dd($beforePayments);
        $payment->residual           = $payment->unit_price - $allPayments + $payment->payment_recovery;
        $payment->discount           = $request->input('discount');
        $discount     = $payment->discount/100;

            if ($discount) {
                $payment->cash_payment  = $payment->residual - ($payment->residual * $discount);
            }

            $countPayments     = Payment::select()->where([['customer_id', $payment->customer_id], ['unit_id', $payment->unit_id]])->count('payment_value');
            if ($payment->installments) {
                $payment->installment_value  = $payment->residual/$payment->installments;
                /// convert float to number without point .  ////
                $payment->installment_value  = intval($payment->installment_value, 2) + 1 ;
                /// convert float to number have 2 point numbers .00  ////
                // $payment->installment_value  = round($payment->installment_value, 2);
            }
            $oldPayments     = Payment::select()->where([['customer_id', $payment->customer_id], ['unit_id', $payment->unit_id]])->get();

            foreach ($oldPayments as $oldPayment) {
                if (!empty($oldPayment->installments)) {
                    $payment->installments       = $oldPayment->installments;
                    $payment->installment_value  = $oldPayment->installment_value;
                }
            }

        $payment->save();

        // STORE IN RESIDUAL TABLE
        // STORE IN RESIDUAL TABLE
        // STORE IN RESIDUAL TABLE
        $unit = Unit::find($payment->unit_id);
        $unit_price = $unit->unit_price;
        $residuals  = Residual::select()->where([['customer_id', $payment->customer_id], ['unit_id', $request->input('unit_id')]])->get();

        $residual = new Residual();

        $residual->unit_id           = $payment->unit_id;
        $residual->customer_id       = $payment->customer_id;
        $residual->payment_id        = $payment->id;
        $residual->unit_price        = $unit_price;
        $residual->all_recoveries  = $payment->payment_recovery;
        $residual->cancellation_code = $payment->cancellation_code;

        if (count($residuals) > 0 ) {
            foreach ($residuals as $item) {
            }
            $residual->all_payments      = $payment->payment_value + $item->all_payments;
            $residual->all_residuals          = $unit_price - $residual->all_payments;
            // dd($residual->residual);
        } else {
            $residual->all_payments      = $residual->all_payments + $payment->payment_value;
            $residual->all_residuals          = $unit_price - $residual->all_payments;

        }
        // dd($payment, $unit_price);

        $residual->save();
        // # STORE IN RESIDUAL TABLE
        // # STORE IN RESIDUAL TABLE
        // # STORE IN RESIDUAL TABLE

        $payments = Payment::select()->where([['customer_id', $payment->customer_id], ['unit_id', $payment->unit_id]])->get();
        if (count($payments) > 0) {
            $customer = Customer::find($payment->customer_id);
            $customer->paymentKinds()->attach([$payment->payment_kind_id], ['unit_id', $payment->unit_id]);
            // $customer = customer::find($payment->customer_id);
            // $customer->finances()->attach([$payment->finance_id]);
        }
        return redirect('/paymentsIndex')->with('success', 'تم اضافة دفع جديد');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $paymentKinds = PaymentKind::all();
        $payment      = Payment::find($id);
        return view('admins.payments.editPayment', compact('paymentKinds', 'payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {

        $recentValue          = $payment->payment_value;
        $unit_id              = $payment->unit_id;
        $customer_id          = $payment->customer_id;

        if (!empty($request->input('created_at'))) {
            $payment->created_at         = $request->input('created_at')." ".date("H:i:s");
        }
        if (!empty($request->input('payment_value'))) {
            $payment->payment_value      = $request->input('payment_value');
            $payment->update();

            // update residual data
            $firstResidual = Residual::where([['unit_id', $unit_id], ['customer_id', $customer_id]])->first();
            $thisResidual  = Residual::where('payment_id', $payment->id)->first();
            if ($firstResidual->id == $thisResidual->id) {
                $thisResidual->all_payments = $request->input('payment_value');
                $thisResidual->all_residuals = $thisResidual->unit_price - $request->input('payment_value');
            } else {
                $thisResidual->all_payments = $thisResidual->all_payments - $recentValue + $request->input('payment_value');
                $thisResidual->all_residuals = $thisResidual->all_residuals + $recentValue - $request->input('payment_value');
            }
            $thisResidual->update();
            // update all next residuals
            $residuals = Residual::where([['unit_id', $unit_id], ['customer_id', $customer_id], ['id', '>', $thisResidual->id]])->get();
            if (count($residuals) > 0) {
                foreach ($residuals as $residual) {
                    $residual->all_payments = $residual->all_payments - $recentValue + $request->input('payment_value');
                    $residual->all_residuals = $residual->all_residuals + $recentValue - $request->input('payment_value');
                    $residual->update();
                }
            }
        }



        return redirect()->route('unitShow', ['id'=>$payment->unit_id])->with('success', 'تم تعديل الدفعة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $recentValue  = $payment->payment_value;

        if ($payment->delete()) {

            $thisResidual = Residual::where('payment_id', $payment->id)->first();
            $thisResidualId = $thisResidual->id;
            $thisResidual->delete();

            $residuals  = Residual::where([['unit_id', $payment->unit_id], ['customer_id', $payment->customer_id], ['id', '>', $thisResidualId]])->get();
            if (count($residuals) > 0) {
                foreach ($residuals as $residual) {
                    $residual->all_payments  = $residual->all_payments - $recentValue;
                    $residual->all_residuals = $residual->all_residuals + $recentValue;
                    $residual->update();
                }
            }

            $customer = Customer::find($payment->customer_id);
            $customer->find($payment->customer_id)->paymentKinds()->newPivotStatement()->where('customer_id', [$payment->customer_id])->where('payment_kind_id', [$payment->payment_kind_id])->where('unit_id', [$payment->unit_id])->delete();


            return back()->with('success', 'تم حذف الدفعة');
        } else {
            return back()->with('none', 'فشل الحذف');
        }

    }

    public function newPaymentFunction(Request $request)
    {

        $payment = new Payment();

        if ($request->input('payment_kind_id') != 999999999) {
            $findPaymentKind = PaymentKind::find($request->input('payment_kind_id'));
            $code            = $findPaymentKind->code;
            $payments = Payment::where([['unit_id', $request->input('unit_id')], ['customer_id', $request->input('customer_id')], ['payment_kind_id', $request->input('payment_kind_id')]])->get();
            if (count($payments) > 0 ) {
                if ($code == 0) {
                return back()->with('none', 'هذه الدفعة غير متعددة وتم تسجيلها مسبقا');
                }
            }
        }
        $payment->unit_id            = $request->input('unit_id');
        $payment->customer_id        = $request->input('customer_id');
        $payment->payment_kind_id    = $request->input('payment_kind_id');
        if (!empty($request->input('created_at'))) {
            $payment->created_at         = $request->input('created_at')." ".date("H:i:s");
        }
        if ( empty($request->input('payment_value')) || is_null($request->input('payment_value')) ) {
            $payment->payment_value      = 0;
        } else {
            $payment->payment_value      = $request->input('payment_value');
        }
        if ( empty($request->input('cancellation_code')) || is_null($request->input('cancellation_code')) ) {
            $payment->cancellation_code  = 0;
        } else {
            $payment->cancellation_code  = $request->input('cancellation_code');
        }
        if ( empty($request->input('payment_recovery')) || is_null($request->input('payment_recovery')) ) {
            $payment->payment_recovery   = 0 ;
        } else {
            $payment->payment_recovery   = $request->input('payment_recovery');
        }

        // CHECK IF RESIDUAL DOSE NOT MORE THAN PAYMENT VALUE

        $residuals  = Residual::select()->where([['unit_id', $payment->unit_id], ['customer_id', $payment->customer_id]])->get();

        if (count($residuals) > 0 ) {
            foreach ($residuals as $item) {
            }
            $residual      = $payment->unit->unit_price - $item->all_payments - $payment->payment_value + $item->all_recoveries + $payment->payment_recovery;
            if ($residual < 0) {
                return back()->with('danger', 'المبلغ المتبقي اقل من المبلغ المدفوع');
            } elseif ($residual > $payment->unit->unit_price) {
                return back()->with('danger', 'المبلغ المتبقي اكبر من المبلغ المستحق');
            }
        }
        $payment->save();


        // STORE IN RESIDUAL TABLE
        // STORE IN RESIDUAL TABLE
        // STORE IN RESIDUAL TABLE

        $residual = new Residual();

        $residual->unit_id           = $payment->unit_id;
        $residual->customer_id       = $payment->customer_id;
        $residual->payment_id        = $payment->id;
        $residual->unit_price        = $payment->unit->unit_price;
        $residual->cancellation_code = $payment->cancellation_code;

        if (count($residuals) > 0 ) {
            foreach ($residuals as $item) {
            }
            $residual->all_payments      = $payment->payment_value + $item->all_payments;
            $residual->all_recoveries  = $payment->payment_recovery + $item->all_recoveries;
        } else {
            $residual->all_payments      = $payment->payment_value;
            $residual->all_recoveries  = $payment->payment_recovery;
        }
        $residual->all_residuals     = $residual->unit_price - $residual->all_payments + $residual->all_recoveries;

        $residual->save();
        // # STORE IN RESIDUAL TABLE
        // # STORE IN RESIDUAL TABLE
        // # STORE IN RESIDUAL TABLE

        //----- Attachments for Pivot -----
        $payments = Payment::select()->where([['customer_id', $payment->customer_id], ['unit_id', $payment->unit_id]])->get();
        if (count($payments) > 0) {
            $customer = Customer::find($payment->customer_id);
            $customer->paymentKinds()->attach([$payment->payment_kind_id], ['unit_id'=> $payment->unit_id]);
        }
        //##### Attachments for Pivot #####

        if ($request->input('payment_kind_id') == 999999999) {
            return redirect()->route('cancellationUnits', ['id'=> 1 ])->with('', 'تم اضافة دفعة استرداد');
        }

        return redirect()->route('unitShow', ['id'=>$payment->unit_id])->with('success', 'تم تسجبل دفعة جديدة بنجاج');
    }
}
