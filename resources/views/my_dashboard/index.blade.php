@extends('layouts.my_dashboard.app')

@section('content')
<div class="card-body">
    @if (session('messages'))
    <div class="alert alert-success" role="alert">
        {{ session('messages') }}
    </div>
    @elseif (session('success'))
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
<div class="card-body">
    @if (isset($array_returned))
        @include('admins.includes.filter_cash_table')
    @endif
</div>
<div class="cards">
    @forelse ($index['mainProjects'] as $mainProject)
    <a href="{{ route('show_main_project',['id'=>$mainProject->id]) }}">
        <div class="card-single">
            <div class="card-data">
                <h3>{{$mainProject->name}}</h3>
                <span>{{$mainProject->property->name}}</span><br>
                <span class="text-warning">{{count($mainProject->units)}} عدد الوحدات</span><br>
                <span class="text-warning">{{count(\App\Models\Unit::where([['status', 'تعاقد'], ['main_project_id', $mainProject->id]])->get())}} وحدات تعاقد</span><br>
                <span class="text-warning">{{count($mainProject->units) - count(\App\Models\Unit::where([['status', 'تعاقد'], ['main_project_id', $mainProject->id]])->get())}} وحدات خالية</span>
            </div>
        </div>
    </a>
    @empty
    <a href="{{ url('/welcome') }}">
        <div class="card-single">
            <div>
                <span style="font-size: 90%">لا يوجد مشاريع</span>
                <span style="font-size: 90%">اضافة اول مشروع</span>
            </div>
        </div>
    </a>
    @endforelse
</div>
<div class="card-header">
    <!-- Button trigger modal -->
    <a href="" type="button" class="info text-light table-buttons" data-toggle="modal" data-target="#cashModal">{{ __('فلتر التدفقات النقدية') }}</a>
    <a href="" type="button" class="info text-light table-buttons" data-toggle="modal" data-target="#statusModal">{{ __('فلترت تعاقدات الوحدات') }}</a>
</div>
@if (isset($units_returned))
@include('admins.includes.filter_status_units')
@endif

<div class="card-header mt-2">
    <a href="{{ route('payments.search', ['day'=>'today']) }}" class="primary m-1"><span> مدوفعات اليوم</span>
        <strong class="warning">{{ $index['todayPayments']->sum('payment_value') + $index['todayInstallments']->sum('installment_value') }}</strong>
    </a>
    <a href="{{ route('payments.search', ['day'=>'week']) }}" class="primary m-1"><span> مدوفعات الاسبوع</span>
        <strong class="warning">{{ $index['current_week']->sum('payment_value') + $index['installments_week']->sum('installment_value') }}</strong>
    </a>
    <a href="{{ route('payments.search', ['day'=>'month']) }}" class="primary m-1"><span> مدوفعات الشهر</span>
        <strong class="warning">{{ $index['current_month']->sum('payment_value') + $index['installments_month']->sum('installment_value') }}</strong>
    </a>
    <a href="" class="primary m-1"><span> الكل </span>
        <strong class="warning">{{ $index['all_payments'] + $index['all_installments'] }}</strong>
    </a>
</div>

<div class="card-header mt-2">
    <a href="{{ route('units.search', ['id'=>date('Y-m-d')]) }}" class="primary m-1"><span> تعاقدات اليوم</span>
        <strong class="warning">{{ count($index['units_day']) }}</strong>
    </a>
    <a href="{{ route('units.search', ['id'=>'week']) }}" class="primary m-1"><span> تعاقدات الاسبوع</span>
        <strong class="warning">{{ count($index['units_week']) }}</strong>
    </a>
    <a href="{{ route('units.search', ['id'=>date('m')]) }}" class="primary m-1"><span> تعاقدات الشهر</span>
        <strong class="warning">{{ count($index['units_month']) }}</strong>
    </a>
    <a href="" class="primary m-1"><span>كل تعاقدات </span>
        <strong class="warning">{{ count($index['units_all']) }}</strong>
    </a>
</div>

<div class="card-header mt-2">
    <!-- Filter Modal -->
    @include('admins.includes.filter_modal_cash')
    @include('admins.includes.filter_modal_status')
    <!-- #Filter Modal -->
</div>

@endsection
