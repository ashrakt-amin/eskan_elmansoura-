
@extends('layouts.my_dashboard.app')

@section('content')
{{-- {{ Auth::user()->privilege_id == 1 ? Auth::user()->name : '' }} --}}
{{-- {{dd(session()->all())}} --}}
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
<div class="card-body">
    <a href="{{ route('users.create') }}" class="btn warning" href="">اضافة مستخدم جديد</a>
    <div class="table-responsive">

        <table width="100%">
            <thead>
            <tr>
                <td>id</td>
                <td>الاسم</td>
                <td>السن</td>
                <td>الهاتف</td>
                <td>الصلاحية</td>
                <td>امر</td>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                <tr>
                    <td class="text-xl-center">{{ $item->id }}</td>
                    <td class="text-lg-center"><a href="{{ route('users.show', ['user'=>$item->id]) }}">{{ $item->name }}</a></td>
                    <td class="text-xl-center">{{ $item->age }}</td>
                    <td class="text-xl-center">{{ $item->phone }}</td>
                    <td class="text-xl-center">{{$item->privilege_id == 0 ? 'ليس له صلاحية'.$item->privilege->name :  $item->privilege->name }}</td>
                    <td class="text-xl-center">
                        <a class="btn btn-primary btn-sm" href="{{ route('users.edit', ['user'=>$item->id]) }}">تعديل</a>
                        <!-- Button trigger modal -->
                        <a type="button" class="btn btn-danger btn-sm text-light" data-toggle="modal" data-target="#exampleModal{{$item->id}}">حذف</a>
                    </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> حذف المستخدم</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>هل تريد حذف المستخدم</p>
                                <strong class="danger"><h1>{{ $item->name }}</h1></strong>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                {{-- <a class="danger table-buttons" href="{{ route('privileges.destroy', ['privilege'=>$item->id]) }}">تاكيد الحذف</a> --}}
                                <button form="delete{{$item->id}}" class="danger table-buttons">تاكيد الحذف</button>
                                <form id="delete{{$item->id}}" action="{{ route('privileges.destroy', ['privilege'=>$item->id]) }}" method="POST">@csrf @method('DELETE')</form>
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
