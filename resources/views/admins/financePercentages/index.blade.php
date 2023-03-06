
@extends('layouts.my_dashboard.app')

@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        {{-- <a href="{{url('financePercentages/add')}}" class="warning table-buttons">نسبة دفع جديدة</a> --}}
        <a href="{{ url('installmentsIndex') }}" class="secondary table-buttons">الاقساط</a>
        <a href="{{ url('paymentsIndex') }}" class="secondary table-buttons">المدفوعات</a>
        <a href="{{ url('financesIndex') }}" class="secondary table-buttons">انظمة السداد</a>
        <a href="{{ url('paymentKindsIndex') }}" class="secondary table-buttons">الدفعات</a>
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
                        <td>الوحدة</td>
                        <td>المبنى</td>
                        <td>المشروع</td>
                        <td>نظام الدفع</td>
                        <td>عرض</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($financePercentages->unique('unit_id') as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td><a href="{{ url('unitShow/'.$item->unit->id) }}">{{ $item->unit->name }}</a></td>
                        <td><a href="{{ url('showConstruction/'.$item->unit->construction_id) }}">{{ $item->unit->construction->name }}</a></td>
                        <td><a href="{{ url('showMainProject/'.$item->unit->main_project_id) }}">{{ $item->unit->mainProject->name }}</a></td>
                        <td>{{ $item->unit->finance->name }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('financePercentages.show', ['id'=>$item->id]) }}">عرض</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
