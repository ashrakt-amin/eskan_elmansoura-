
@extends('layouts.my_dashboard.app')

@section('content')

    <!-- -------------------------------------------------  -->
    <!-- -------------------------------------------------  -->
    <!-- -------------------------------------------------  -->
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
        <a href="" class="primary"><strong class="warning" style="font-size: 1.7rem">{{ $array }}</strong></a>
        <h3> المشروع  :    {{ $mainProject->name }}</h3>
        <a href="{{ route('balances.index', ['mainProject'=>$mainProject->id]) }}" class="{{ Request::is('balances.index') ? 'active' : '' }} "><span class=" sidebar-li-text">ميزان مراجعة مبسط</span></a>
        <a href="?add" class="primary">اضافة منشئات </a>
    </div>

@if (isset($_GET['add']))
    @include('admins.constructions.customAddConstrutionsNavbar')
@endif
    <div class="card-body">
        <div>
            @forelse ($mainProject->constructions->unique('property_id') as $construction_property)
            <a href="{{ route('searchProperties', ['id'=>$construction_property->property_id, 'main_project'=>$construction_property->main_project_id]) }}" class="secondary table-buttons">{{ $construction_property->property->name }}</a>
            @empty
            <a>لا يوحد وحدات</a>
            @endforelse
        </div>
    </div>
    <div class="cards">
        {{-- @forelse ($mainProject->constructions as $construction) --}}
        @forelse (\App\Models\Construction::where('main_project_id', $mainProject->id)->orderby('id', 'asc')->get() as $construction)
        <a class="primary" href="{{ route('showConstruction', ['id'=>$construction->id]) }}">
            @foreach ($construction->units as $unit)
            @endforeach
            <div class="card-single">
                <div class="card-data">
                    <h3>{{$construction->name}}</h3>
                    @if ($construction->main_project_id !== 3)
                    <span>{{$construction->property->name}}</span><br>
                    @endif
                    <span class="text-warning">{{count($construction->units)}} عدد الوحدات</span><br>
                    <span class="text-warning">{{count(\App\Models\Unit::where([['status', 'تعاقد'], ['main_project_id', $construction->main_project_id], ['construction_id', $construction->id]])->get())}} وحدات تعاقد</span><br>
                    <span class="text-warning">{{count($construction->units) - count(\App\Models\Unit::where([['status', 'تعاقد'], ['main_project_id', $construction->main_project_id], ['construction_id', $construction->id]])->get())}} وحدات خالية</span>
                </div>
            </div>
        </a>
        @empty
        <a href="{{ route('addConstruction') }}">
            <div class="card-single">
                <div>
                    <span>اضافة منشأة </span>
                </div>
                <div>
                    <span class="las la-users"></span>
                </div>
            </div>
        </a>
        @endforelse


    </div>

@endsection

