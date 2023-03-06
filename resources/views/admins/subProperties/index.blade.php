
@extends('layouts.my_dashboard.app')

@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        <a href="{{ route('subProperties.create') }}" class="warning table-buttons" href="">اضافة قسم فرعي جديد</a>
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
                        <td>القسم</td>
                        <td>امر</td>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($subProperties as $item)
                    @foreach ($item->properties->unique('property_id') as $items)
                    @endforeach
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td><a href="{{ route('subProperties.show',   ['subProperty' => $item->id])}}">{{ $item->name }}</a></td>
                        <td>
                            <a class="btn btn-warning" href="{{ route('subProperties.edit', ['subProperty'=> $item->id]) }}">تعديل</a>
                            <!-- Button trigger modal -->
                            <a type="button" class="btn btn-danger" href="" data-toggle="modal" data-target="#exampleModal{{ $item->id }}">حذف </a>
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
                                    <p> هل تريد حذف القسم الفرعي<strong class="danger">("{{ $item->name }}") </strong></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                    <button form="delete{{$item->id}}" class="danger table-buttons">تاكيد الحذف</button>
                                    <form id="delete{{$item->id}}" action="{{route('subProperties.destroy', ['subProperty'=>$item->id])}}" method="POST">@csrf @method('DELETE')</form>
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
