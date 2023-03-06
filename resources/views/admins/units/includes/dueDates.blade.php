
@php

    // $financePercentages_sum = \App\Models\FinancePercentage::where('unit_id', $unit->id)->sum('payment_kind_value');
    $financePercentages     = \App\Models\FinancePercentage::orderBy('payment_kind_id', 'ASC')->where('unit_id', $unit->id)->get();
@endphp
@if (count($financePercentages) > 0 )


<div class="card-body">
    <div class="card-header">
        <a class="danger"></a>
        <h3 class="text-danger text-center">{{ __('مواعيد الاستحقاق') }}{{'    '}}</h3>
        <a type="button" class="danger mr-1" href="" data-toggle="modal" data-target="#deleteAllFinanceModal{{__('all')}}">{{ __('حذف الكل') }}</a>
    </div>

    <!-- Add Due Dates Modal -->
    <div class="modal fade" id="deleteAllFinanceModal{{__('all')}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">اضافة مواعيد الاستحقاق</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>هل تريد حذف <strong class="danger">{{ __('كل مواعيد الاستحقاق') }}</strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                        <a class="danger table-buttons" href="{{ route('financePercentages.delete', ['id'=>'all', 'unit_id'=>$unit->id]) }}">تاكيد الحذف</a>
                    </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" style="width: 100%">
        <table width="100%">
            <thead>
                <tr>
                    <td>id</td>
                    <td>الدفعة</td>
                    <td>نسبة الدفعة</td>
                    <td>قيمة الدفعة</td>
                    <td>تاريخ الاستحقاق</td>
                    <td>امر</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $id = 0 ;
                @endphp
                @foreach ($financePercentages as $item)
                <tr>
                    <td>{{ ++$id }}</td>
                    <td>{{ $item->payment_kind_id ? $item->paymentKind->name : '' }}</td>
                    <td>{{ $item->payment_kind_percentage ? $item->payment_kind_percentage.'%' : 'لم يتم ادخال قيمة' }}</td>
                    <td>{{ $item->payment_kind_value ? $item->payment_kind_value : 'لم يتم ادخال قيمة' }}</td>
                    <td>{{ $item->due_date ? $item->due_date : 'لم يتم اختيار تاريخ' }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ url('financePercentages/edit/'.$item->id) }}">تعديل</a>
                        <a type="button" class="btn btn-danger" href="" data-toggle="modal" data-target="#deleteFinanceModal{{$item->id}}">{{ __('حذف') }}</a>
                    </td>
                </tr>
                <!-- Add Due Dates Modal -->
                <div class="modal fade" id="deleteFinanceModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">اضافة مواعيد الاستحقاق</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-dark"> هل تريد حذف ميعاد الاستحقاق <strong class="danger">("{{ $item->paymentKind->name }}") </strong></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                    <a class="danger table-buttons" href="{{ route('financePercentages.delete', ['id'=>$item->id]) }}">تاكيد الحذف</a>
                                </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <tr>
                    <td colspan="1">{{ __('اجمالي الوحدة') }}</td>
                    <td colspan="">{{$unit->unit_price}}</td>
                    <td colspan="">{{ __('دائن') }}</td>
                    <td colspan="">{{$financePercentages->sum('payment_kind_value')}}</td>
                    <td>{{ __('مدين') }}</td>
                    <td colspan="1">{{$unit->unit_price - $financePercentages->sum('payment_kind_value')}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endif
