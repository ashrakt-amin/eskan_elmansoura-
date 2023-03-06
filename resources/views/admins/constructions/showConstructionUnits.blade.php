
@extends('layouts.my_dashboard.app')

@section('content')

<div class="col-lg-12">
    <div class="card-header">
        <h3 class="text-center">{{ $constructions->name }}</h3>
    </div>
    <table class="table table-light table-bordered">
        <thead>
        <tr>
            <th scope="col" class="text-xl-center">اسم الوحدة</th>
            <th scope="col" class="text-xl-center">الحالة</th>
            <th scope="col" class="text-xl-center">العميل</th>
            <th scope="col" class="text-xl-center">الموقع</th>
            <th scope="col" class="text-xl-center">المساحة</th>
            <th scope="col" class="text-xl-center">سعر المتر</th>
            <th scope="col" class="text-xl-center">سعر الوحدة</th>
            <th scope="col" class="text-xl-center">الدور</th>

        </tr>
        </thead>
        <tbody>
            {{-- {{ dd($constructions) }} --}}
@foreach ($units as $item)

        <tr>
            <td><a href="{{ url('unitShow/'.$item->id) }}" class="btn btn-primary m-2" style="width: 125px">{{$item->name}}</a></td>
            <td><a href="#" class="btn btn-outline-info m-2" style="width: 125px">{{$item->status}}</a></td>
            <td><a href="{{ url('customerShow/'.$item->customers->id) }}" class="btn btn-outline-danger m-2 d-inline-block" style="font-size: 1vw">{{$item->customers->name}}</a></td>
            <td><a href="#" class="btn btn-outline-info m-2" style="width: 125px">{{$item->site}}</a></td>
            <td><a href="#" class="btn btn-outline-info m-2" style="width: 125px">{{$item->space}}</a></td>
            <td><a href="#" class="btn btn-outline-info m-2" style="width: 125px">{{$item->price_m}}</a></td>
            <td><a href="#" class="btn btn-outline-info m-2" style="width: 125px">{{$item->unit_price}}</a></td>
            <td><a href="#" class="btn btn-outline-info m-2" style="width: 125px">{{$item->level->name}}</a></td>


        </tr>
@endforeach
        </tbody>
    </table>
</div>

@endsection
