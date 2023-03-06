<div class="bordered mb-5">
    @if (count($units_returned['array']) > 0)
        @foreach ($units_returned['array'] as $array)
            @if (count($array['units']) > 0)
            <div class="bordered">
                <div class="card-header">
                    <a href="" class="table-buttons text-light d-inline"><strong class="">{{ $array['mainProject']->name }}</strong></a>
                    <a href="" class="text-light table-buttons"><strong class="">{{ $array['construction']->name }}</strong></a>
                    <a href="" class="table-buttons"><strong class="warning">{{ '('.count($array['units']).')' }}</strong>{{__(' ')}}{{__('عدد الوحدات')}}</a>
                </div>
                <div class="cards">
                    @foreach ($array['units'] as $unit)
                    <a href="{{ route('unitShow', ['id'=>$unit->id]) }}"
                        @if ($unit->status == 'خالية') class="primary"
                        @elseif ($unit->status == 'تعاقد') class="danger"
                        @elseif ($unit->status == 'محجوزة') class="success"
                        @elseif ($unit->status == 'ملغاة') class="warning"
                        @endif
                        >
                        <div
                            @if ($unit->status == 'خالية') class="primary"
                            @elseif ($unit->status == 'تعاقد') class="danger"
                            @elseif ($unit->status == 'محجوزة') class="success"
                            @elseif ($unit->status == 'ملغاة') class="warning"
                            @endif
                            >
                        <div class="card-data">
                            <h3>" {{$unit->name}} " وحدة </h3>
                            <span>{{$unit->customer_id != 0 ? $unit->customers->name.' '.$unit->customers->mid_name.' '.$unit->customers->last_name : ''}}</span><br><br>
                            <span>{{$unit->space}}{{'م'}}</span><br>
                            <span></span><br>
                            <span>{{$unit->unit_price}} س</span><br>
                        </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
    @else
    <div class="card-header">
        <a></a>
        <a class="warning table-buttons">{{ __('لا يوجد') }}</a>
        <a></a>
    </div>
    @endif
</div>
