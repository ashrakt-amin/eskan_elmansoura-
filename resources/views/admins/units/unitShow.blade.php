@extends('layouts.my_dashboard.app')

@section('content')

@if (count($unit->customers->payments) > 0)
@foreach ($unit->customers->payments as $payment)
@endforeach
@endif
@include('admins.units.includes.unitShowHeader')
<div class="">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @elseif (session('none'))
        <div class="alert alert-primary" role="alert">
            {{ session('none') }}
        </div>
        @elseif (session('warning'))
        <div class="alert alert-warning" role="alert">
            {{ session('warning') }}
        </div>
        @elseif (session('danger'))
        <div class="alert alert-danger" role="alert">
            {{ session('danger') }}
        </div>
        @elseif (session('status'))
        <div class="alert alert-danger" role="alert">
            {{ session('status') }}
        </div>
    @endif
</div>

    <div class="">
        {{-- Start unit information table --}}
        {{-- Start unit information table --}}
        {{-- Start unit information table --}}
            @include('admins.units.includes.unitInformations')
        {{-- End unit information table --}}
        {{-- End unit information table --}}
        {{-- End unit information table --}}
    </div>
    @if ($unit->customer_id !== 0)
    @if (empty($unit->finance_id))
    <div class="">
        <a type="button" class="danger mr-1" href="" data-toggle="modal" data-target="#addFinanceModal{{$unit->id}}">اضافة نظام الدفع </a>
        {{-- Start unit Due Dates table --}}
        {{-- Start unit Due Dates table --}}
        {{-- Start unit Due Dates table --}}
            @include('admins.units.includes.financePercentage')
        {{-- End unit Due Dates table --}}
        {{-- End unit Due Dates table --}}
        {{-- End unit Due Dates table --}}
    </div>
    @endif
    @endif
    @if (!empty($unit->finance_id))
    <div class="">
        @php
            $financePercentages = \App\Models\FinancePercentage::orderBy('payment_kind_id', 'ASC')->where('unit_id', $unit->id)->get();
            $paymentKinds       = \App\Models\PaymentKind::where([['main_project_id', $unit->main_project_id], ['code', 0]])->get();
            // dd(count($financePercentages) , count($paymentKinds));
        @endphp
        @if (count($financePercentages) == 0 || count($financePercentages) !== count($paymentKinds))
        <div class="text-center mb-1">
            <a type="button" class="danger mr-1" href="" data-toggle="modal" data-target="#addDueFinanceModal{{$unit->id}}">اضافة مواعيد الاستحقاق </a>
        </div>
        @endif
        {{-- Start unit Due Dates table --}}
        {{-- Start unit Due Dates table --}}
        {{-- Start unit Due Dates table --}}
        @include('admins.units.includes.dueDates')
        @include('admins.financePercentages.create')
        {{-- End unit Due Dates table --}}
        {{-- End unit Due Dates table --}}
        {{-- End unit Due Dates table --}}
    </div>
    @endif
    <div class="card-header">
        <div></div>
        <a class="text-light">  {{$unit->unit_price}}  اجمالي الوحدة</a>
        <div></div>
    </div>
    <div class="card-header">
        <p>المدفوعات</p>
    </div>
@if (isset( Auth::user()->privilege_id) && Auth::user()->privilege_id != 0)


    @if (\App\Models\Payment::where([['unit_id', $unit->id], ['cancellation_code', 0 ], ['customer_id', $unit->customer_id]])->count('id') > 0 )
    <div class="">

        {{-- Start unitPayment tr include --}}
        {{-- Start unitPayment tr include --}}
        {{-- Start unitPayment tr include --}}


        <!--------- المدفوعات --------->
        <!--------- المدفوعات --------->

        <div class="table-responsive">
            <table width="100%">
                <thead>
                    <tr>
                        <td>دائن</td>
                        <td>مدين</td>
                        <td>نوع الدفعة</td>
                        <td>الاجمالي </td>
                        <td>المتبقي</td>
                        <td>التاريخ </td>
                        <td>الوقت </td>
                        <td>أمر</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $paymentsArray = array();
                        $payments = \App\Models\Payment::where([['unit_id', $unit->id], ['customer_id', $unit->customer_id]])->get();
                        foreach ($payments as $item) {
                            array_push($paymentsArray, $item);
                        }
                        asort($paymentsArray);
                    @endphp
                    @forelse ($paymentsArray as $payment)

                    <tr>
                        @if (\App\Models\Payment::where([['unit_id', $unit->id], ['customer_id', $unit->customer_id]])->count('id') == 0)
                            <td><a>لا يوجد  </a> </td>
                        @else
                        <td>{{ $payment->payment_value}}</td>
                        <td>{{ $payment->payment_recovery}}</td>
                        <td>{{ $payment->payment_kind_id != '999999999' ? $payment->paymentKind->name : 'دفعة استرداد' }}</td>
                        <td>{{ $payment->residual->all_payments}}</td>
                        <td>{{ $payment->residual->all_residuals}} </td>
                        <td>{{ $payment->created_at->format('Y-m-d')}}</td>
                        <td>{{ $payment->created_at->format('h:i A')}}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ url('editPayment/'.$payment->id) }}">تعديل</a>
                            <!-- Button trigger modal -->
                            <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#paymentexampleModal{{$payment->id}}">حذف </a>
                        </td>
                        @endif
                    </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="paymentexampleModal{{$payment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"> حذف القسم</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>هل تريد حذف <strong class="danger">{{ __('ال') }}</strong><strong class="danger">{{ $payment->paymentKind->name }}</strong></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                        <a class="danger table-buttons" href="{{ route('payment.destroy', ['payment' =>$payment->id]) }}">تاكيد الحذف</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty

                    <tr>
                        <td></td>
                    </tr>

                    @endforelse
                </tbody>
            </table>
        </div>

        <!--######## المدفوعات ###########-->
        <!--######## المدفوعات ###########-->


        {{-- End unitPayment tr include --}}
        {{-- End unitPayment tr include --}}
        {{-- End unitPayment tr include --}}

    </div>

    {{-- @if (\App\Models\Payment::where([['unit_id', $unit->id], ['cancellation_code', 0 ], ['customer_id', $unit->customer_id]])->count('payment_kind_id') == count(\App\Models\PaymentKind::where('main_project_id', $unit->main_project_id)->get())) --}}
        {{-- @if ($payments->count('payment_kind_id') < count($paymentKinds)) --}}
    <div class="">
        {{-- Start unitFinancePercentage td include --}}
        @include('admins.units.includes.unitPaymentKind')
        {{-- End unitFinancePercentage td include --}}

        {{-- @include('admins.units.includes.unitInstallmentMonth') --}}

    </div>
    {{-- @else --}}
    <div>
    {{-- Start include installment month form --}}
        @include('admins.units.includes.unitInstallmentMonth')
    {{-- End include installment month form --}}
    {{-- @endif --}}
    </div>
    <div>
    {{-- Start include unit installment tablr --}}
        @include('admins.units.includes.unitInstallmentTable')
    {{-- End include unit installment tablr --}}


    {{-- Start Show all installments --}}
    {{-- Start Show all installments --}}
    {{-- Start Show all installments --}}

    {{-- @include('admins.units.includes.unitInstallmentsShow') --}}

    {{-- End Show all installments --}}
    {{-- End Show all installments --}}
    {{-- End Show all installments --}}
    </div>
    @elseif (\App\Models\Payment::where([['unit_id', $unit->id], ['cancellation_code', 0 ], ['customer_id', $unit->customer_id]])->count('id') == 0 )
    <div>
        @if ($unit->customer_id !== 0)
        {{-- Start unitFinancePercentage td include --}}
        {{-- Start unitFinancePercentage td include --}}
        {{-- Start unitFinancePercentage td include --}}


        @include('admins.units.includes.unitPaymentKind')


        {{-- End unitFinancePercentage td include --}}
        {{-- End unitFinancePercentage td include --}}
        {{-- End unitFinancePercentage td include --}}
        @endif

    </div>
    @endif
@endif



  @endsection
