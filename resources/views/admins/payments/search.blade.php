@extends('layouts.my_dashboard.app')

@section('content')


<div class="card-body">
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
            @endif
    </div>
</div>
<div class="card-header">
    <a href="{{ url('paymentsIndex') }}" class="secondary table-buttons">كل الدفعات</a>
    <a href="{{ url('installmentsIndex') }}" class="secondary table-buttons">الاقساط</a>
    <a class="secondary table-buttons" href="{{ route('financePercentages.index') }}">نسب الدفعات</a>
    <a href="{{ url('financesIndex') }}" class="secondary table-buttons">انظمة السداد</a>
</div>
<!--------- المشاريع --------->
<!--------- المشاريع --------->
<div class="card-body m-1">
    @if (isset($todayPayments))
    <div class="card-header">
        <a href="{{ route('payments.search', ['day'=>'week']) }}" class="primary m-1"><span>مدوفعات الاسبوع</span></a>
        <div><strong class="danger">{{"( ". $todayPayments->sum('payment_value') + $todayInstallments->sum('installment_value') ." )"}}</strong><span>اجمالي اليوم</span></div>
        <a href="{{ route('payments.search', ['day'=>'month']) }}" class="primary m-1"><span> مدوفعات الشهر</span></a>
    </div>
    @if (count($todayPayments) >0 )
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <td class="sum" colspan="4">اجمالي المدفوعات اليوم</td>
                    <td class="sum">{{ $todayPayments->sum('payment_value') }}</td>
                </tr>
                <tr>
                    <td>الوحدة</td>
                    {{-- <td>المبنى</td> --}}
                    <td>العميل</td>
                    {{-- <td>المدفوع</td> --}}
                    <td>تاريخ الحركة</td>
                    <td>الدفعة</td>
                    <td> قيمة الدفعة</td>
                </tr>
            </thead>
            <tbody>


                @foreach ($todayPayments as $payment)

                <tr>
                    <td><a href="{{ url('unitShow/'.$payment->unit_id) }}"> {{ $payment->unit->name }}</a></td>
                    {{-- <td><a href="{{ url('showConstruction/'.$payment->construction_id) }}">{{ $payment->unit->construction->name }}</a></td> --}}
                    <td><a href="{{ url('customerShow/'.$payment->customer_id) }}"> {{ $payment->customer->name }} </a></td>
                    {{-- <td><a>{{ $payment->residual->all_payments }}</a></td> --}}
                    <td><a href="">{{ $payment->created_at }}</a></td>
                    <td><a>{{ $payment->paymentKind->name }}</a></td>
                    <td><a>{{ $payment->payment_value }}</a></td>
                </tr>

                @endforeach

                @else



            </tbody>
        </table>
    </div>
    @endif
    @if (count($todayInstallments) > 0 )
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <td class="sum" colspan="4">اجمالي اقساط اليوم</td>
                    <td class="sum">{{ $todayInstallments->sum('installment_value') }}</td>
                </tr>
                <tr>
                    <td>الوحدة</td>
                    {{-- <td>المبنى</td> --}}
                    <td>العميل</td>
                    {{-- <td>المدفوع</td> --}}
                    <td>تاريخ الحركة</td>
                    <td>شهر</td>
                    <td> قيمة الدفعة</td>
                </tr>
            </thead>
            <tbody>


                @foreach ($todayInstallments as $installment)

                <tr>
                    <td><a href="{{ url('unitShow/'.$installment->unit_id) }}"> {{ $installment->unit->name }}</a></td>
                    {{-- <td><a href="{{ url('showConstruction/'.$payment->construction_id) }}">{{ $payment->unit->construction->name }}</a></td> --}}
                    <td><a href="{{ url('customerShow/'.$installment->unit->customer_id) }}"> {{ $installment->unit->customers->name }} </a></td>
                    {{-- <td><a>{{ $payment->residual->all_payments }}</a></td> --}}
                    <td><a href="">{{ $installment->created_at }}</a></td>
                    <td><a>{{ $installment->installment_month}}</a></td>
                    <td><a>{{ $installment->installment_value }}</a></td>
                </tr>

                @endforeach

                @else

            </tbody>
        </table>
    </div>
    @endif
    @endif
    @if (isset($current_week))
    <div class="card-header">
        <a href="{{ route('payments.search', ['day'=>'today']) }}" class="primary m-1"><span> مدوفعات اليوم</span></a>
        <div><strong class="danger">{{"( ". $current_week->sum('payment_value') + $installments_week->sum('installment_value') ." )"}}</strong><span>اجمالي الاسبوع</span></div>
        <a href="{{ route('payments.search', ['day'=>'month']) }}" class="primary m-1"><span> مدوفعات الشهر</span></a>
    </div>
    @if (count($current_week) > 0 )
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <td class="sum" colspan="4">اجمالي المدفوعات الاسبوع</td>
                    <td class="sum">{{ $current_week->sum('payment_value') }}</td>
                </tr>
                <tr>
                    <tr>
                        <td>الوحدة</td>
                        {{-- <td>المبنى</td> --}}
                        <td>العميل</td>
                        {{-- <td>المدفوع</td> --}}
                        <td>تاريخ الحركة</td>
                        <td>الدفعة</td>
                        <td> قيمة الدفعة</td>
                    </tr>
                </tr>
            </thead>
            <tbody>
                @foreach ($current_week as $item)
                <tr>
                    <td><a href="{{ url('unitShow/'.$item->unit_id) }}"> {{ $item->unit->name }}</a></td>
                    {{-- <td><a href="{{ url('showConstruction/'.$item->construction_id) }}">{{ $item->unit->construction->name }}</a></td> --}}
                    <td><a href="{{ url('customerShow/'.$item->customer_id) }}"> {{ $item->customer->name }} </a></td>
                    {{-- <td><a>{{ $item->residual->all_payments }}</a></td> --}}
                    <td><a href="">{{ $item->created_at }}</a></td>
                    <td><a>{{ $item->paymentKind->name }}</a></td>
                    <td><a>{{ $item->payment_value }}</a></td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> حذف القسم</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>هل تريد حذف <strong class="danger">{{ $item->name }}</strong></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                <a class="danger table-buttons" href="{{ url('deleteProperty/'.$item->id) }}">تاكيد الحذف</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @if (count($installments_week) > 0 )
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <td class="sum" colspan="4">اجمالي اقساط الاسبوع</td>
                    <td class="sum">{{ $installments_week->sum('installment_value') }}</td>
                </tr>
                <tr>
                    <td>الوحدة</td>
                    {{-- <td>المبنى</td> --}}
                    <td>العميل</td>
                    {{-- <td>المدفوع</td> --}}
                    <td>تاريخ الحركة</td>
                    <td>شهر</td>
                    <td> قيمة القسط</td>
                </tr>
            </thead>
            <tbody>


                @foreach ($installments_week as $installment)

                <tr>
                    <td><a href="{{ url('unitShow/'.$installment->unit_id) }}"> {{ $installment->unit->name }}</a></td>
                    {{-- <td><a href="{{ url('showConstruction/'.$payment->construction_id) }}">{{ $payment->unit->construction->name }}</a></td> --}}
                    <td><a href="{{ url('customerShow/'.$installment->unit->customer_id) }}"> {{ $installment->unit->customers->name }} </a></td>
                    {{-- <td><a>{{ $payment->residual->all_payments }}</a></td> --}}
                    <td><a href="">{{ $installment->created_at }}</a></td>
                    <td><a>{{ $installment->installment_month}}</a></td>
                    <td><a>{{ $installment->installment_value }}</a></td>
                </tr>

                @endforeach

                @else



            </tbody>
        </table>
    </div>
    @endif
    @endif
    @if (isset($current_month))
    <div class="card-header">
        <a href="{{ route('payments.search', ['day'=>'today']) }}" class="primary m-1"><span> مدوفعات اليوم</span></a>
        <div><strong class="danger">{{"( ". $current_month->sum('payment_value') + $installments_month->sum('installment_value') ." )"}}</strong><span>اجمالي الشهر</span></div>
        <a href="{{ route('payments.search', ['day'=>'week']) }}" class="primary m-1"><span>مدوفعات الاسبوع</span></a>
    </div>
    @if (count($current_month) > 0 )
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <td class="sum" colspan="4">اجمالي المدفوعات الشهر</td>
                    <td class="sum">{{ $current_month->sum('payment_value') }}</td>
                </tr>
                <tr>
                    <tr>
                        <td>الوحدة</td>
                        {{-- <td>المبنى</td> --}}
                        <td>العميل</td>
                        {{-- <td>المدفوع</td> --}}
                        <td>تاريخ الحركة</td>
                        <td>الدفعة</td>
                        <td> قيمة الدفعة</td>
                    </tr>
                </tr>
            </thead>
            <tbody>
                @foreach ($current_month as $item)
                <tr>
                    <td><a href="{{ url('unitShow/'.$item->unit_id) }}"> {{ $item->unit->name }}</a></td>
                    {{-- <td><a href="{{ url('showConstruction/'.$item->construction_id) }}">{{ $item->unit->construction->name }}</a></td> --}}
                    <td><a href="{{ url('customerShow/'.$item->customer_id) }}"> {{ $item->customer->name }} </a></td>
                    {{-- <td><a>{{ $item->residual->all_payments }}</a></td> --}}
                    <td><a href="">{{ $item->created_at }}</a></td>
                    <td><a>{{ $item->paymentKind->name }}</a></td>
                    <td><a>{{ $item->payment_value }}</a></td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> حذف القسم</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>هل تريد حذف <strong class="danger">{{ $item->name }}</strong></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                <a class="danger table-buttons" href="{{ url('deleteProperty/'.$item->id) }}">تاكيد الحذف</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @if (count($installments_month) > 0 )
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <td class="sum" colspan="4">اجمالي اقساط الشهر</td>
                    <td class="sum">{{ $installments_month->sum('installment_value') }}</td>
                </tr>
                <tr>
                    <td>الوحدة</td>
                    {{-- <td>المبنى</td> --}}
                    <td>العميل</td>
                    {{-- <td>المدفوع</td> --}}
                    <td>تاريخ الحركة</td>
                    <td>شهر</td>
                    <td> قيمة القسط</td>
                </tr>
            </thead>
            <tbody>


                @foreach ($installments_month as $installment)

                <tr>
                    <td><a href="{{ url('unitShow/'.$installment->unit_id) }}"> {{ $installment->unit->name }}</a></td>
                    {{-- <td><a href="{{ url('showConstruction/'.$payment->construction_id) }}">{{ $payment->unit->construction->name }}</a></td> --}}
                    <td><a href="{{ url('customerShow/'.$installment->unit->customer_id) }}"> {{ $installment->unit->customers->name }} </a></td>
                    {{-- <td><a>{{ $payment->residual->all_payments }}</a></td> --}}
                    <td><a href="">{{ $installment->created_at }}</a></td>
                    <td><a>{{ $installment->installment_month}}</a></td>
                    <td><a>{{ $installment->installment_value }}</a></td>
                </tr>

                @endforeach

                @else



            </tbody>
        </table>
    </div>
    @endif
    @endif
</div>
<!--######## المشاريع ###########-->
<!--######## المشاريع ###########-->

@endsection
