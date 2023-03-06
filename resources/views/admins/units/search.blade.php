@extends('layouts.my_dashboard.app')

@section('content')

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
<div class="card-header mt-2">
    <a href="{{ route('units.search', ['id'=>date('Y-m-d')]) }}" class="primary m-1"><span> تعاقدات اليوم</span>
    </a>
    <a href="{{ route('units.search', ['id'=>'week']) }}" class="primary m-1"><span> تعاقدات الاسبوع</span>
    </a>
    <a href="{{ route('units.search', ['id'=>date('m')]) }}" class="primary m-1"><span> تعاقدات الشهر</span>
    </a>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <td>المشروع</td>
                    <td> عدد الوحدات</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($units as $unit)

                @endforeach

                @if (count($units) > 0 )
                <tr>
                    <td><a href="{{ route('show_main_project', ['id'=>$unit->mainProject->id]) }}">{{$unit->mainProject->name}}</a></td>
                    <td>{{ count($units) }}</td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
</div>
<div class="cards">
    @if (count($units) > 0  )
    @forelse ($units as $unit)

    <a href="{{ route('unitShow', ['id'=>$unit->id]) }}"
        @if ($unit->status == 'خالية') class="primary"
        @elseif ($unit->status == 'تعاقد') class="danger"
        @elseif ($unit->status == 'محجوزة') class="success"
        @elseif ($unit->status == 'ملغاة') class="warning"
        @endif
        >
        <div
            {{-- @if ($unit->status == 'خالية') class="primary"
            @elseif ($unit->status == 'تعاقد') class="danger"
            @elseif ($unit->status == 'محجوزة') class="success"
            @elseif ($unit->status == 'ملغاة') class="warning"
            @endif --}}
            >
            <div class="card-data">
                <h3>" {{$unit->name}} " وحدة </h3>
                <span>{{$unit->updated_at->format('Y-m-d')}}</span><br>
                <span>{{$unit->customer_id != 0 ? $unit->customers->name.' '.$unit->customers->mid_name.' '.$unit->customers->last_name : ''}}</span><br><br>
                <span>{{$unit->space}}{{'م'}}</span><br>
                <span></span><br>
                <span>{{$unit->unit_price}} س</span><br>
                <span>{{$unit->subProperty->name}} </span><br>

            </div>
        </div>
    </a>
    @empty
    <a href="{{ url('/welcome') }}" class="info">
        <div class="card-single info">
            <div>
                <span style="font-size: 90%">لا يوجد وحدات</span>
                <span style="font-size: 90%">________________</span>
            </div>
        </div>
    </a>
    @endforelse
    @endif

</div>

@endsection
