@extends('layouts.my_dashboard.app')

@section('content')

    <div class="card" style="width: ;">
        <div class="card-header">
            <a class="warning" href="{{ route('editCustomer', ['id'=>$customer->id]) }}">تحديث البيانات</a>
            <h1>
                {{ $customer->name.' '.$customer->mid_name.' '.$customer->last_name }} {{$customer->id}}
            </h1>
            <span><strong class="danger">{{ "(".count($customer->units). ")" }}</strong> <span>عدد الوحدات</span></span>
            {{-- <a href=""><img src="{{asset('assets/images/uploads/customer/'.$customer->image)}}" class="w-50 m-0 p-0" alt="image here"></a> --}}
            <a href="https://mail.google.com/mail/u/0/?tab=rm#inbox?compose=new" class="warning">
                {{ $customer->email }}
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table width="100%">
                    <thead>
                        <tr>
                            <td>السن</td>
                            <td>النوع</td>
                            <td>الرقم القومي</td>
                            <td>الهاتف</td>
                            <td>معلومات</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $customer->age }}</td>
                            <td>{{ $customer->gender }}</td>
                            <td>{{ $customer->national_id }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->additional_info }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table width="100%">
                    <thead>
                        <tr>
                            <td>الوحدة</td>
                            <td>القسم</td>
                            <td>المنشأة</td>
                            <td>المشروع الرئيسي</td>
                            <td>سعر الوحدة</td>
                            <td>الدور</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer->units as $unit)
                        <tr>
                            <td><a href="{{ url('unitShow/'.$unit->id) }}">{{$unit->name}}</a></td>
                            <td><a href="{{ route('subProperties.show', ['subProperty'=>$unit->sub_property_id]) }}">{{$unit->subProperty->name}}</a></td>
                            <td><a href="{{ url('showConstruction/'.$unit->construction->id) }}">{{$unit->construction->name}}</a></td>
                            <td><a href="{{ url('show_main_project/'.$unit->mainProject->id) }}">{{$unit->mainProject->name}}</a></td>
                            <td>{{$unit->unit_price}}</td>
                            <td><a href="{{ route('levels.show', ['id'=>$unit->level_id, 'constructionId'=>$unit->construction->id]) }}">{{$unit->level->name}}</a></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="cards2">
                @foreach ($customer->units as $unit)
                <div>
                    <div class="card-header">
                        <a href="{{ url('unitShow/'.$unit->id) }}" class="primary"> ----ما تم دفعه {{ $unit->payments->sum('payment_value') + $unit->installments->sum('installment_value')}}</a>
                        <a href="{{ url('unitShow/'.$unit->id) }}" class="danger"> الوحدة {{$unit->name}}</a>
                        <a href="{{ url('unitShow/'.$unit->id) }}" class="primary"> ----قيمة الوحدة {{$unit->unit_price}}</a>
                    </div>
                    <div class="card-header">
                        <p>المدفوعات</p>
                    </div>
                    <div class="table-responsive">
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>المدفوع</td>
                                <td>اسم الدفعة</td>
                                <td>اجمالي الدفعات</td>
                                <td>المتبقي</td>
                                <td>نظام الدفع</td>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($unit->payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_value}}</td>
                                <td>{{ $payment->paymentKind->name}} </td>
                                <td>{{ $payment->residual->all_payments}} </td>
                                <td>{{$payment->residual->all_residuals}} </td>
                                @if (is_null($payment->finance))
                                <td>لم يشترك بعد</td>
                                @else

                                <td><a href="{{ url('financeShow/'.$payment->finance_id) }}" class="btn btn-outline-info m-2">{{$payment->finance->name}}</a></td>
                                @endif
                            </tr>
                            @endforeach

                            @foreach ($unit->installments as $installment)
                                @php
                                    $months_array[] = $installment->installment_month;
                                @endphp
                            @endforeach

                        </tbody>
                    </table>
                    <div class="card-header">
                        <p>الاقساط</p>
                    </div>
                    <div class="table-responsive">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <td class="">القسط</td>
                                    <td class=""> الشهر</td>
                                    <td class="">المتبقي</td>
                                    <td class="">الأقساط المتبقية</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($unit->installments as $installment)
                                @php
                                    $months_array[] = $installment->installment_month;
                                @endphp

                                <tr>
                                    <td>{{ $installment->installment_value}}</td>
                                    <td>{{ $installment->installment_month}}</td>
                                    <td>{{ $installment->residual->all_residuals}}</td>
                                    <td>{{ $installment->residual_installments}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
  @endsection
