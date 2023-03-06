@extends('layouts.my_dashboard.app')

@section('content')
<div class="">
    <div class="card-header">
        <a href="{{ route('constructionsIndex') }}" class="danger">اضغط على المباني لاضافة وحدة</a>
        <a href="{{ url('cancellationUnits/1') }}" class="warning">الوحدات المسترجعة</a>

    </div>
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
        @elseif (session('status'))
        <div class="alert alert-primary" role="alert">
            {{ session('status') }}
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table width="100%">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>{{ __('المشروع الرئيسي') }}</td>
                        <td>{{ __('رقم الوحدة') }}</td>
                        <td>{{ __('سعر المتر') }}</td>
                        <td>{{ __('نسبة الزيادة') }}</td>
                        <td>{{ __('السعر الجديد للمتر') }}</td>
                        <td>{{ __('السعر الوحدة') }}</td>
                        <td>{{ __('السعر الجديد للوحدة') }}</td>
                        <td> امر</td>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($overMuchUnits as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td class="text-xl-center">{{ $item->mainProject->name }}</td>
                        <td><a href="{{ url('unitShow/'.$item->unit_id) }}">{{ $item->unit_name }}</a></td>
                        <td class="text-xl-center">{{ $item->price_m }}</td>
                        <td class="text-xl-center">{{ $item->over_much }}</td>
                        <td class="text-xl-center">{{ $item->new_price_m }}</td>
                        <td class="text-xl-center">{{ $item->unit_price }}</td>
                        <td class="text-xl-center">{{ $item->new_unit_price }}</td>
                        <td>
                            <a class="btn btn-primary mr-1" href="{{ url('editUnit/'.$item->id) }}">تعديل</a>
                            <!-- Button trigger modal -->
                            <a type="button" class="btn btn-danger mr-1" href="" data-toggle="modal" data-target="#exampleModal{{$item->id}}">حذف </a>
                        </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"> حذف الوحدة</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p> هل تريد حذف الوحدة رقم    <strong class="danger">("{{ $item->name }}") </strong></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                            <a class="danger table-buttons" href="{{ route('unit.destroy', ['id'=>$item->id]) }}">تاكيد الحذف</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
