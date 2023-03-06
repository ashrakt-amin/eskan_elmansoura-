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

<div class="card-header">
    <!-- Button trigger modal -->
    <a href="" type="button" class="info text-light table-buttons" data-toggle="modal" data-target="#exampleModal{{$construction->id}}">فلتر البحث </a>
    <!-- Filter Modal -->
    @include('admins.includes.filter_modal_construction_units')
    <!-- #Filter Modal -->

    <h1 style="text-align: center">{{ $construction->name }}</h1>

    <a href="?add" class="info table-buttons">اضافة وحدات</a>
</div>
@if (isset($_GET['add']))
    @include('admins.units.includes.customAddUnitNavbar')
@endif

<div class="card-body">

    <a href="{{ route('overMuchUnits.index') }}" class="table_buttons warning">{{ __('وحدات زيادة اسعار') }}</a>
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <td>المشروع</td>
                    <td> عدد الوحدات</td>
                    <td>{{ __('تدفقات نقدية') }}</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($construction->units->sortBy('id') as $unit)

                @endforeach

                @if (count($construction->units) > 0 )
                <tr>
                    <td><a href="{{ route('show_main_project', ['id'=>$unit->mainProject->id]) }}">{{$unit->mainProject->name}}</a></td>
                    <td>{{ count($construction->units) }}</td>
                    <td>{{ $array }}</td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
</div>
<div class="cards">
    @if (count($construction->units) > 0  && $construction->main_project_id != 3)
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
        @elseif ($unit->status == 'ملغاة') class="secondary"
        @endif --}}
        >
            <div class="card-data">
                <h3>" {{$unit->name}} " وحدة </h3>
                <span>{{$unit->customer_id != 0 ? $unit->customers->name.' '.$unit->customers->mid_name.' '.$unit->customers->last_name : ''}}</span><br><br>
                <span>{{$unit->space}}{{'م'}}</span><br>
                <span>{{$unit->unit_price}} س</span><br>
                {{-- @if ($unit->mainProject->id == 2 ) --}}
                <span>{{ __('الدور') }} {{ $unit->level->name }}</span><br>
                {{-- @endif --}}
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
