@extends('layouts.my_dashboard.app')

@section('content')

    <div class="card" style="width: ;">
        <div class="card-header">
            <a class="warning" href="{{ route('editCustomer', ['id'=>$customer->id]) }}">تحديث البيانات</a>
            <h2>
                {{ $customer->name.' '.$customer->mid_name.' '.$customer->last_name }} {{$customer->id}}
            </h2>
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
                            <td>{{ __('السن') }}</td>
                            <td>{{ __('النوع') }}</td>
                            <td>{{ __('الرقم القومي') }}</td>
                            <td>{{ __('الهاتف') }}</td>
                            <td>{{ __('مديونية العميل') }}</td>
                            <td>{{ __('مدفوعات العميل') }}</td>
                            <td>{{ __('عمولات') }}</td>
                            <td>{{ __('الفرق') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $customer->age }}</td>
                            <td>{{ $customer->gender }}</td>
                            <td>{{ $customer->national_id }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->units->sum('unit_price') }}</td>
                            <td>{{ $customer->payments->sum('payment_value') + $customer->installments->sum('installment_value') }}</td>
                            <td>{{ $customer->commissions->sum('commission_value') }}</td>
                            <td>
                                {{
                                $customer->units->sum('unit_price') -
                                $customer->payments->sum('payment_value') + $customer->installments->sum('installment_value') -
                                $customer->commissions->sum('commission_value')
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table width="100%">
                    <thead>
                        <tr><td colspan="6">{{ __('جدول تعاقدات الوحدات') }}</td></tr>
                    </thead>
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
            <div class="table-responsive">
                <table width="100%" style="background-color: rgb(253, 228, 85)">
                    <thead>
                        <tr><td colspan="6">{{ __('جدول عمولات الوحدات') }}</td></tr>
                    </thead>
                    <thead>
                        <tr>
                            <td>الوحدة</td>
                            <td>القسم</td>
                            <td>المنشأة</td>
                            <td>المشروع الرئيسي</td>
                            <td>سعر الوحدة</td>
                            <td>قيمة العمولة</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer->commissions as $commission)
                        <tr>
                            <td><a href="{{ url('unitShow/'.$commission->unit->id) }}">{{$commission->unit->name}}</a></td>
                            <td><a href="{{ route('subProperties.show', ['subProperty'=>$commission->unit->sub_property_id]) }}">{{$commission->unit->subProperty->name}}</a></td>
                            <td><a href="{{ url('showConstruction/'.$commission->unit->construction->id) }}">{{$commission->unit->construction->name}}</a></td>
                            <td><a href="{{ url('show_main_project/'.$commission->unit->mainProject->id) }}">{{$commission->unit->mainProject->name}}</a></td>
                            <td>{{$commission->unit->unit_price}}</td>
                            <td class="bg-warning">{{$commission->commission_value}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5">اجمالي العمولات</td>
                            <td class="bg-warning">{{$customer->commissions->sum('commission_value')}}</td>
                        </tr>

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
                                <td>{{ $payment->payment_kind_id != 999999999 ? $payment->paymentKind->name : 'دفعة استرجاع'}} </td>
                                <td>{{ $payment->residual->all_payments}} </td>
                                <td>{{$payment->residual->all_residuals}} </td>
                                @if ($unit->finance_id == 0)
                                <td>غير مشترك</td>
                                @else
                                <td>{{$unit->finance->name}}</td>
                                @endif
                            </tr>
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
