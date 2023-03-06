
@extends('layouts.my_dashboard.app')

@section('content')

    <!-- -------------------------------------------------  -->
    <!-- -------------------------------------------------  -->
    <!-- -------------------------------------------------  -->
    <div class="card-header">
        @forelse ($constructions->unique('main_project_id') as $construction)

        <h3> المشروع  :    {{ $construction->mainProject->name }}</h3>
        <div>(" {{ count($constructions) }} ")اجمالي المبانى</div>
        <a href="?add" class="primary">اضافة مبنى </a>
        @empty
        @if (!is_null($mainProject))
        <h3> المشروع  :    {{ $mainProject->name }}</h3>
        @else
        <h3>لا يوجد مشروع تحت القسم</h3>
        @endif
        <a href="?add" class="primary">اضافة منشئات </a>

        @endforelse
    </div>

@if (isset($_GET['add']))
    @include('admins.constructions.customAddConstrutionsNavbar')
@endif
<label class="m-2 w-25 text-center">اقسام المباني المتاحة</label>
<div class="card-body">
    @if (!is_null($mainProject))
    <div>
        <a href="{{ route('show_main_project', ['id'=>$mainProject->id]) }}" class="success table-buttons">{{ $mainProject->name }}</a>
        @forelse ($mainProject->constructions->unique('property_id') as $construction_property)
        <a href="{{ route('searchProperties', ['id'=>$construction_property->property_id, 'main_project'=>$construction_property->main_project_id]) }}" class="warning table-buttons">{{ $construction_property->property->name }}</a>
        @empty
        <a>لا يوحد وحدات</a>
        @endforelse
    </div>
    @endif
</div>
<div class="cards">
    @forelse ($constructions as $construction)
    <a href="{{ route('showConstruction', ['id'=>$construction->id]) }}">
        @foreach ($construction->units as $unit)
        @endforeach
        <div class="card-single">
            <div class="card-data">
                <h3>{{$construction->name}}</h3>
                <span>{{$construction->property->name}}</span><br>
                <span class="text-warning">{{count($construction->units)}} عدد الوحدات</span><br>
                <span class="text-warning">{{count(\App\Models\Unit::where([['status', 'تعاقد'], ['main_project_id', $construction->main_project_id], ['construction_id', $construction->id]])->get())}} وحدات تعاقد</span><br>
                <span class="text-warning">{{count($construction->units) - count(\App\Models\Unit::where([['status', 'تعاقد'], ['main_project_id', $construction->main_project_id], ['construction_id', $construction->id]])->get())}} وحدات خالية</span>
            </div>
        </div>
    </a>
    @empty
    <a href="?add">
        <div class="card-single">
            <div>
                <span>لا يوجد مباني بالقسم </span>
                <br>
                <br>
                <h3 class="text-center">اضافة مبنى </>
            </div>
            <div>
                <span class="las la-users"></span>
            </div>
        </div>
    </a>
    @endforelse


</div>
@endsection
