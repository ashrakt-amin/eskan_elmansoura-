@extends('layouts.my_dashboard.app')

@section('content')
<div class="card-header">
    <a href="?do=addLevel" class="warning table-buttons" href="">اضافة طابق جديد</a>
    <h1>الطوابق</h1>
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
                    <td class="text-lg-center text-danger" style="font-size: 22px">id</td>
                    <td class="text-lg-center text-danger" style="font-size: 22px">level</td>
                    <td class="text-lg-center text-danger" style="font-size: 22px">do</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($levels as $level)
                <tr>
                    <td class="text-lg-center text-danger" style="font-size: 20px">{{$level->id}}</td>
                    <td class="text-lg-center" style="font-size: 20px">{{$level->name}}</td>
                    <td class="text-lg-center" style="font-size: 20px">
                        <a class="btn btn-primary" href="{{ url('editLevel/'.$level->id) }}">تعديل</a>
                        <!-- Button trigger modal -->
                        <a type="button" class="btn btn-danger" href="" data-toggle="modal" data-target="#exampleModal{{ $level->id }}">حذف </a>
                    </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{$level->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> حذف الوحدة</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p> هل تريد حذف الطابق<strong class="danger">("{{ $level->name }}") </strong></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                <a class="danger table-buttons" href="{{ route('level/delete', ['id'=>$level->id]) }}">تاكيد الحذف</a>
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
