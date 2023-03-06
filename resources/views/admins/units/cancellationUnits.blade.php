@extends('layouts.my_dashboard.app')

@section('content')
<div class="card-header">
    <div></div>
    <a href="{{ route('unitsIndex') }}" class="warning table-buttons">الوحدات</a>
    <div></div>
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
                    <td>الوحدة</td>
                    <td>المنشأة</td>
                    <td>المشروع </td>
                    <td>{{ __('دائن') }}</td>
                    <td>{{ __('مدين') }}</td>
                    <td>تاريخ المعالة</td>
                    <td>باقي مستحقاته </td>
                    <td> عميل</td>
                    <td> امر</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments->unique('unit_id') as $item)
                <tr>
                    <td ><a href="{{ route('unitShow', ['id'=>$item->unit_id]) }}">{{ $item->unit->name }}</a></td>
                    <td><a href="{{ route('showConstruction', ['id'=>$item->unit->construction_id]) }}">{{ $item->unit->construction->name }}</a></td>
                    <td><a href="{{ route('show_main_project', ['id'=>$item->unit->main_project_id]) }}">{{ $item->unit->mainProject->name }}</a></td>
                    <td>{{ $sum_payment_value = \App\Models\Payment::where([['unit_id', $item->unit_id], ['customer_id', $item->customer_id]])->sum('payment_value') }}</td>
                    <td>{{ $sum_payment_recovery = \App\Models\Payment::where([['unit_id', $item->unit_id], ['customer_id', $item->customer_id]])->sum('payment_recovery') }}</td>
                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                    <td>{{ $sum_payment_value - $sum_payment_recovery }}</td>
                    <td><a href="{{ route('customerShow', ['id'=>$item->customer_id]) }}">@if ($item->customer_id) {{ $item->customer->name }} @else   @endif</a></td>
                    <td>
                        <a class="btn btn-primary btn-sm m-1" href="{{ url('editPayment/'.$item->id) }}">تعديل</a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
