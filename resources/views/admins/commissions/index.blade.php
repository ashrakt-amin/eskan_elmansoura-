@extends('layouts.my_dashboard.app')

@section('content')

<div class="card-header">
    {{-- <a href="{{ route('commissions.create') }}" class="secondary table-buttons">{{ __('تحديث') }}</a> --}}
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#commissionModal">{{ __('اضافة عمولة') }}</button>
    @include('admins.commissions.create')
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
                    <td scope="col" class="text-xl-center">{{__('العميل')}}</td>
                    <td scope="col" class="text-xl-center">{{__('الوحدة')}}</td>
                    <td scope="col" class="text-xl-center">{{__('المبنى')}}</td>
                    <td scope="col" class="text-xl-center">{{__('المشروع')}}</td>
                    <td scope="col" class="text-xl-center">{{__('النسبة')}}</td>
                    <td scope="col" class="text-xl-center">{{__('المبلغ')}}</td>
                    <td scope="col" class="text-xl-center">امر</td>
                </tr>
            </thead>
            <tbody>
                {{-- {{dd($commissions)}} --}}
                @foreach ($commissions as $item)
                <tr>
                    <td class="text-xl-center">{{ $item['id'] }}</td>
                    <td class="text-xl-center"><a href="{{ route('customerShow', ['id'=>$item['customer']['id']]) }}">{{ $item['customer']['name'].' '.$item['customer']['last_name'] }}</a></td>
                    <td class="text-xl-center"><a href="{{ route('unitShow', ['id'=>$item['unit']['id']]) }}">{{ $item['unit']['name'] }}</a></td>
                    <td class="text-xl-center"><a href="{{ route('showConstruction', ['id'=>$item['construction']['id']] )}}">{{ $item['construction']['name'] }}</a></td>
                    <td class="text-xl-center"><a href="{{ route('show_main_project', ['id'=>$item['mainProject']['id']]) }}">{{ $item['mainProject']['name'] }}</a></td>
                    <td class="text-xl-center">{{ $item['percentage'].' '.'%' }}</td>
                    <td class="text-xl-center">{{ $item['commission_value'] }}</td>
                    <td class="text-xl-center">
                        <a class="btn btn-primary" href="">تعديل</a>
                        <!-- Button trigger modal -->
                        <a type="button" class="btn btn-danger text-light" data-toggle="modal" data-target="#exampleModal{{$item['id']}}">حذف </a>
                    </td>
                </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$item['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> حذف القسم</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>هل تريد حذف     <strong class="danger">{{ $item['id'] }}</strong></p>
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
