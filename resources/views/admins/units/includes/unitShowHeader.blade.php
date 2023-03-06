
    <div class="card-header mb-1">
        @if ($unit->status == 'خالية')
            <a class=" table-buttons" href="{{ url('editUnitStatus/'.$unit->id.'?status=حجز') }}">{{__('حجز')}}</a>
        @elseif ($unit->status == 'تعاقد')
            <a  class="danger table-buttons" href="{{ url('customerShow/'.$unit->customers->id) }}" style="font-size: 1rem">
                {{$unit->customers->name.' '.$unit->customers->last_name}}
            </a>
        @elseif ($unit->status == 'محجوزة')
        <a  class="success table-buttons" href="{{ url('customerShow/'.$unit->customers->id) }}">{{$unit->customers->name.' '.$unit->customers->last_name}}</a>
        @else
        <a class=" table-buttons"href="{{ url('editUnitStatus/'.$unit->id.'?status=حجز') }}">حجز</a>
        @endif

        <h1 class=" under-line">({{$unit->name}}) الوحدة
        </h1>
        @if ($unit->status == 'محجوزة')
        <a class="success table-buttons" href="{{ url('editUnitStatus/'.$unit->id.'?status=تعاقد') }}">{{__('اتمام التعاقد')}}</a>
        @endif
        @if (count($unit->payments) > 0)
        <a href="">
            <span> مدفوعات </span>
            <strong class="warning" style="font-size: 1.7rem">
                {{ $unit->payments->sum('payment_value') + $unit->installments->sum('installment_value')}}
            </strong>
        </a>
        @endif
    </div>

<div class="card-header">
    <a class="warning" href="{{ url('editUnit/'.$unit->id) }}">تحديث البيانات</a>
    <!-- Button trigger modal -->
    @if (!$unit->commission )
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#commissionModal">{{ __('اضافة عمولة') }}</button>
    @include('admins.commissions.create')
    @else
    <a href="{{ route('customerShow', ['id'=>$unit->commission->customer->id]) }}" class="btn btn-primary"><strong class="warning">{{ $unit->commission->customer->name.' '.$unit->commission->customer->last_name }}</strong>{{ __(' تم اضافة عمولة للعميل') }}</a>
    @endif

    <a type="button" class="danger mr-1" href="" data-toggle="modal" data-target="#exampleModal{{$unit->id}}">حذف </a>

    <a href="{{ url('searchConstruction/'.$unit->construction->id.'/?status='.$unit->status) }} "
        @if ($unit->status == 'خالية') class="primary"
        @elseif ($unit->status == 'تعاقد') class="danger"
        @elseif ($unit->status == 'محجوزة') class="success"
        @elseif ($unit->status == 'ملغاة') class="secondary"
        @endif
    > الحالة : {{$unit->status}}
    </a>

    @if ($unit->status == 'تعاقد')
    <div class="">
        <a href="{{ url('editUnitStatus/'.$unit->id.'?status=لاتعاقد') }} " class="danger table-buttons">{{'الغاء التعاقد'}}</a>
    </div>
    @elseif(($unit->status == 'محجوزة'))
    <a href="{{ url('editUnitStatus/'.$unit->id.'?status=لامحجوزة') }} " class="success table-buttons">{{__('الغاء الحجز')}}</a>
    @endif
</div>

    <!-- Delete Modal -->
    <div class="modal fade" id="exampleModal{{$unit->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> حذف الوحدة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p> هل تريد حذف الوحدة رقم    <strong class="danger">("{{ $unit->name }}") </strong><strong>{{$unit->subProperty->name}}</strong></p>
                        <p>الموجودة ب    <strong class="danger">("{{ $unit->construction->name }}") </strong><strong>{{$unit->property->name}}</strong></p>
                        <p>من مشروع   <strong class="danger">("{{ $unit->mainProject->name }}")</strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                        <a class="danger table-buttons" href="{{ route('unit.destroy', ['id'=>$unit->id]) }}">تاكيد الحذف</a>
                    </div>
            </div>
        </div>
    </div>
