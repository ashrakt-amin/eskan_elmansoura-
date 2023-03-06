
@extends('layouts.my_dashboard.app')

@section('content')

    <!-- -------------------------------------------------  -->
    <!-- -------------------------------------------------  -->
    <!-- -------------------------------------------------  -->
    <div class="card-header">
        <div></div>
        <h3> قسم الوحدات  :    <strong class="danger">ال{{ $sub_property->name }}</strong></h3>
        <div></div>
    </div>
    <div class="bordered mb-5">
        <div class="cards">
            @if (count($units) > 0 )
            @foreach ($units as $unit)
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
            @endif
    </div>
</div>

@endsection

