
@extends('layouts.my_dashboard.app')

@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        @foreach ($financePercentages as $item)
        @endforeach
        <a href="{{ url('unitShow/'.$item->unit->id) }}">{{ $item->unit->name }}<span> الوحدة </span></a>
        <a href="{{ $item->unit->customer_id > 0 ? url('customerShow/'.$item->unit->customer_id) : '' }}">{{ $item->unit->customers->name }}</a>
        <a href="{{ url('showConstruction/'.$item->unit->construction_id) }}">{{ $item->unit->construction->name }}<strong class="warning"> {{ $item->unit->mainProject->name }} </strong></a>
        <a href="">{{ $item->unit->finance->name }}</a>
    </div>
    <div class="card-body">
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
    <div class="card-body">
        <div class="table-responsive" style="width: 100%">
            <table width="100%">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>النسبة</td>
                        <td>نوع الدفعة</td>
                        <td>ميعاد الاستحقاق</td>
                        <td>امر</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($financePercentages as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->payment_kind_percentage }}</td>
                        <td>{{ $item->payment_kind_value }}</td>
                        <td>{{ $item->due_date }}</td>
                        <td>{{ $item->payment_kind_id ? $item->paymentKind->name : '' }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ url('financePercentages/edit/'.$item->id) }}">تعديل النسبة</a>
                            <a class="btn btn-danger" href="#modal_box">حذف النسبة</a>
                        </td>
                    </tr>
                    <div id="modal_box" class="modal">
                        <div class="modalContent">
                            {{-- <p>هل تريد حذف النسبة من دفعة  <span>{{ $item->paymentKind->name }}</span></p> --}}
                            {{-- <a class="danger table-buttons" href="{{ url('financePercentages/delete/'.$item->id.'/'.$item->payment_kind_id) }}">تاكيد الحذف </a> --}}
                            <a class="modalClose" href="">&times;</a>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
