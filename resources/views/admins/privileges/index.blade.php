@extends('layouts.my_dashboard.app')

@section('content')

<div class="card-body">
    <a href="{{ route('privileges.create') }}" class="btn warning mb-2">اضافة صلاحية</a>
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
                    <td>id</td>
                    <td>الصلاحية</td>
                    <td>الكود</td>
                    <td>امر</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($privileges as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td class="text-xl-center">
                        <a>{{ $item->name }}</a>
                    </td>
                    <td>{{ $item->code }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm mr-1" href="{{ route('privileges.edit', ['privilege'=>$item->id]) }}">تعديل الصلاحية</a>
                        <!-- Button trigger modal -->
                        <a type="button" class="btn btn-danger btn-sm mr-1 text-light" data-toggle="modal" data-target="#exampleModal{{$item->id}}">حذف الصلاحية</a>
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
                                <p>هل تريد حذف     <span>{{ $item->name }}</span></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                {{-- <a class="danger table-buttons" href="{{ route('privileges.destroy', ['privilege'=>$item->id]) }}">تاكيد الحذف</a> --}}
                                <button form="delete{{$item->id}}" class="btn btn-danger btn-sm">تاكيد الحذف</button>
                                <form id="delete{{$item->id}}" action="{{ route('privileges.destroy', ['privilege'=>$item->id]) }}" method="POST">@csrf @method('DELETE')</form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
