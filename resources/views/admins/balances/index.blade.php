@extends('layouts.my_dashboard.app')

@section('content')

<div class="card-header">
    <a href="{{ route('balances.create', ['mainProject'=>$mainProject->id]) }}" class="secondary table-buttons">{{ __('تحديث') }}</a>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">{{ __('زيادة أسعار') }}</button>
    @include('admins.includes.over_much_modal')
    <a href="{{ route('balances.create', ['mainProject'=>$mainProject->id]) }}" class="secondary table-buttons"></a>
</div>
<div class="card-body">
    <div class="table-responsive">
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
        <table width="100%">
            <thead>
                <tr>
                    <td scope="col" class="text-xl-center">id</td>
                    <td scope="col" class="text-xl-center">{{__('الحساب المبدئي')}}</td>
                    <td scope="col" class="text-xl-center">{{__('الحساب المتوقع')}}</td>
                    <td scope="col" class="text-xl-center">{{__('الحساب الحالي')}}</td>
                    <td scope="col" class="text-xl-center">{{__('حساب ما تم بيعه')}}</td>
                    <td scope="col" class="text-xl-center">{{__('فرق الحساب')}}</td>
                    <td scope="col" class="text-xl-center">{{__('ترتيب التحديث')}}</td>
                    <td scope="col" class="text-xl-center">امر</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($balances as $item)

                <tr>
                    <td class="text-xl-center">{{ $item->id }}</td>
                    <td class="text-xl-center">{{ $item->starting_balance }}</td>
                    <td class="text-xl-center">{{ $item->excepted_balance }}</td>
                    <td class="text-xl-center">{{ $item->current_balance }}</td>
                    <td class="text-xl-center">{{ $item->actual_balance }}</td>
                    <td class="text-xl-center">{{ $item->current_balance - $item->excepted_balance }}</td>
                    <td class="text-xl-center">{{ $item->balance_code }}</td>
                    <td class="text-xl-center">
                        <a class="btn btn-primary" href="">تعديل</a>
                     <!-- Button trigger modal -->
                     <a type="button" class="btn btn-danger text-light" data-toggle="modal" data-target="#exampleModal{{$item->id}}">حذف </a>
                    </td>
                </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> حذف القسم</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>هل تريد حذف     <strong class="danger">{{ $item->name }}</strong></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                    <a class="danger table-buttons" href="">تاكيد الحذف</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
