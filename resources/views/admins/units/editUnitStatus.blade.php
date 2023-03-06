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
<div class="card-header text-center mb-3">
    <div></div>
    <h1 class="font-weight-bold">("{{ $unit->name }}") رقم الوحدة </h1>
    @if ($unit->customer_id == 0)
    <!-- Button trigger modal -->
    <a href="" type="button" class="info text-light" data-toggle="modal" data-target="#exampleModal{{$unit->id}}">اضافة عميل</a>
    @else
    <div></div>
    @endif
    <!-- Filter Modal -->
    @include('admins.customers.create')
    <!-- #Filter Modal -->
</div>

<div class="card">
    <div class="form-body">
        <div class="form-container">
            <form action="{{ route('updateUnitStatus', ['id'=>$unit->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($unit->status !== 'خالية' && $unit->status !== 'ملغاة')
                <div class="user-details">
                    <div class="input-box" style="width: 100%">
                        <span class="details"></span>
                        <input type="text" class="form-control"value="{{ $unit->customers->name }}" disabled>
                        <input type="hidden" class="form-control" value="{{ $unit->customer_id }}" name="customer_id">
                    </div>
                    <div class="">
                        @if ( $_GET['status'] == 'تعاقد' )
                        <input type="hidden" class="form-control font-weight-bold text-dark" name="status" value="تعاقد" required>
                        @else
                        <input type="hidden" class="form-control font-weight-bold text-dark" name="status" value="ملغاة" required>
                        @endif
                    </div>
                </div>
                <!------------------------------------- Submit ------------------------------------->
                <div class="form-button text-center">
                    @if (isset($_GET['status']))
                    @if ( $_GET['status'] == 'لاتعاقد' )
                    <input type="submit" value="الغاء التعاقد" class="bg-primary">
                    @elseif ( $_GET['status'] == 'لامحجوزة' )
                    <input type="submit" value="الغاء الحجز" class="bg-primary">
                    @elseif ( $_GET['status'] == 'تعاقد' )
                    <input type="submit" value="{{__('اتمام التعاقد')}}" class="bg-danger">
                    @endif
                    @endif
                </div>
                <!--################################### Submit ###################################-->
                @elseif ($unit->status == 'خالية' || $unit->status == 'ملغاة')
                <div class="select-box">
                    <select data-show-subtext="true" data-live-search="true" class="selectpicker btn btn-primary w-100" name="customer_id" id="search-select">
                            <option selected value="0" class="">عميل</option>
                            @foreach ( $customers as $customer)
                            <option data-subtext="{{ $customer->national_id }}" value="{{ $customer->id }}" >{{ $customer->name.' '.$customer->mid_name.' '.$customer->last_name  }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="">
                    <input type="hidden" class="form-control  font-weight-bold text-dark" name="status" value="محجوزة" required>
                </div>
                <!------------------------------------- Submit ------------------------------------->
                <div class="form-button text-center">
                    <input type="submit" value="حجز" class="btn-danger">
                </div>
                <!--################################### Submit ###################################-->
                @endif
            </form>
        </div>
    </div>
    <div class="card-body">
        <table width="100%">
            <thead>
                <tr>
                    <td>المشروع</td>
                    <td>المنشأة</td>
                    <td>الطابق</td>
                    <td>الموقع</td>
                    <td>المساحة</td>
                    <td>سعر المتر</td>
                    <td>سعر الوحدة</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="{{ route('show_main_project', ['id'=>$unit->mainProject->id]) }}">{{$unit->mainProject->name}}</a></td>
                    <td><a href="{{ route('showConstruction', ['id'=>$unit->construction->id]) }}">{{$unit->construction->name}}</a></td>
                    <td><a href="{{ route('levels.show', ['id'=>$unit->level_id, 'constructionId'=>$unit->construction->id]) }}">{{$unit->level->name}}</a></td>
                    <td><a href="">{{$unit->site->name}}</a></td>
                    <td><a href="">{{$unit->space}}</a></td>
                    <td><a href="">{{$unit->price_m}}</a></td>
                    <td><a href="">{{$unit->unit_price}}</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
