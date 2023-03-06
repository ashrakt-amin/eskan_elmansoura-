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
<div class="card-header">
    <h1>
        {{ $user->name.' '.$user->mid_name.' '.$user->last_name }}
    </h1>
    <a href="https://mail.google.com/mail/u/0/?tab=rm#inbox?compose=new" class="btn primary">
        {{ $user->email }}
    </a>
    <img src="{{asset('assets/images/uploads/customer/'.$user->image)}}" alt="image here">
</div>
@if ($user->privilege_id == 1)
<div class="card-header mt-1 mb-1">
    <a class=" warning table-buttons" href="{{ route('users.edit', ['user'=>$user->id]) }}">{{$user->name.' تعديل'}}</a>
    <a class=" primary table-buttons" href="{{ route('users.index') }}">كل المستخدمين</a>
    <!-- Button trigger modal -->
    <a type="button" class="btn danger text-light" data-toggle="modal" data-target="#exampleModal{{$user->id}}">{{$user->name.' حذف'}}</a>
</div>
@else
<div class="card-header mt-1 mb-1">
    <a class=" warning table-buttons" href="{{ route('users.edit', ['user'=>$user->id]) }}">{{$user->name.' تعديل'}}</a>
</div>
@endif
<div class="card-body">
    <div class="table-responsive">
        <table width="100%">
            <thead>
            <tr>
                <td>id</td>
                <td>السن</td>
                <td>الجنس</td>
                <td>الهاتف</td>
                <td>الصلاحية</td>
            </tr>
            </thead>
            <tbody>

                <tr>
                    <td class="text-xl-center">{{ $user->id }}</td>
                    <td class="text-xl-center">{{ $user->age }}</td>
                    <td class="text-xl-center">{{ $user->gender }}</td>
                    <td class="text-xl-center">{{ $user->phone }}</td>
                    <td class="text-xl-center">{{$user->privilege_id == 0 ? 'ليس له صلاحية' :  $user->privilege->name }}</td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <strong class="danger"><h1>{{ $user->name }}</h1></strong>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                {{-- <a class="danger table-buttons" href="{{ route('privileges.destroy', ['privilege'=>$user->id]) }}">تاكيد الحذف</a> --}}
                                <button form="delete{{$user->id}}" class="danger table-buttons">تاكيد الحذف</button>
                                <form id="delete{{$user->id}}" action="{{ route('privileges.destroy', ['privilege'=>$user->id]) }}" method="POST">@csrf @method('DELETE')</form>
                            </div>
                        </div>
                    </div>
                </div>
            </tbody>
        </table>
    </div>
</div>

  @endsection
