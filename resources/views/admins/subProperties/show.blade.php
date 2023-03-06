
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
    <div class="card-body levels-card">
        <div class="btn-cards">
            @foreach (\App\Models\SubProperty::all() as $subProperty)
            <a href="{{ route('subProperties.show', ['subProperty'=>$subProperty->id]) }}" class="secondary">{{ $subProperty->name }}</a>
            @endforeach
        </div>
        {{-- <div class="my-col">
            @foreach ($subProperty->units->unique('level_id') as $unit)
            <a href="{{ route('levels.show', ['id'=>$unit->level->id, 'constructionId'=>$unit->construction->id]) }}" class="info">{{ $unit->level->name }}</a>
            @endforeach
        </div> --}}

    </div>
@foreach (\App\Models\Construction::all() as $construction)
@foreach (\App\Models\Unit::where([['sub_property_id', $sub_property->id], ['construction_id', $construction->id]])->get()->unique('construction_id') as $unit)
<div class="bordered mb-5">
    <div class="warning text-center">
        <a href="{{ route('showConstruction', ['id'=>$construction->id]) }}" class="text-dark">{{$construction->name}}</a>
        {{ ' - مشروع ' }}
        <a href="{{ route('show_main_project', ['id'=>$construction->mainProject->id]) }}" class="text-dark">{{ $construction->mainProject->name }}</a>
    </div>
    <div class="btn-cards">

        <a href="{{ route('searchConstruction', ['id'=>$construction->id, 'status'=>"خالية"]) }}" class="primary">وحدات خالية</a>

        <a href="{{ route('searchConstruction', ['id'=>$construction->id, 'status'=>'تعاقد']) }}" class="danger">وحدات تعاقد</a>

        <a href="{{ route('searchConstruction', ['id'=>$construction->id, 'status'=>'محجوزة']) }}" class="success">وحدات محجوزة</a>

        <a href="{{ route('searchConstruction', ['id'=>$construction->id, 'status'=>'ملغاة']) }}" class="warning">وحدات ملغاة</a>

        <a href="{{ url('showConstruction/'.$construction->id) }}" class="light">كل الوحدات</a>

    </div>
    <div class="cards">
        @forelse (\App\Models\Unit::where([['sub_property_id', $sub_property->id], ['construction_id', $construction->id]])->get() as $unit)
        @if (count(\App\Models\Unit::where([['sub_property_id', $sub_property->id], ['construction_id', $construction->id]])->get()) > 0 )
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
        {{-- <a class="primary" href="{{ route('unitShow', ['id'=>$unit->id]) }}">
            <div class="card-single">
                <div class="card-data">
                    <h3>{{$unit->name}}</h3>
                    <span>{{$unit->subProperty->name}}</span><br>
                    <span>{{$unit->construction->name}}</span><br>
                    <span class="text-warning">{{ $unit->mainProject->name }}  </span>
                </div>
            </div>
        </a> --}}
        @endif
        @empty

        @endforelse
    </div>
</div>
@endforeach
@endforeach

@endsection

