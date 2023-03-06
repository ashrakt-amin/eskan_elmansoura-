@extends('layouts.my_dashboard.app')

@section('content')
<div class="form-body">
    <div class="form-container">
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
        <div class="title">قسم فرعي جديد</div>
        <form action="{{ route('insertLevel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="user-details">
                <div class="input-box" style="width: 100%">
                    <span class="details">اسم القسم الفرعي</span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <stron>{{ $message }}</stron>
                    </span>
                    @enderror
                </div>
            </div>
            <!------------------------------------- Submit ------------------------------------->
            <div class="form-button">
                <input type="submit" value="اضافة">
            </div>
            <!--################################### Submit ###################################-->
        </form>
    </div>
</div>
@endsection
