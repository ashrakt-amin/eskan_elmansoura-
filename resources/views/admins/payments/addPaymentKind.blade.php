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
                @elseif (session('status'))
                <div class="alert alert-primary" role="alert">
                    {{ session('status') }}
                </div>
                @endif
        </div>
        <div class="title">دفعة جديدة</div>
        <form action="{{ url('insertPaymentKind') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="user-details">
                <div class="input-box" style="width: 100%">
                    <span class="details">اسم الدفعة</span>
                    <input type="text" value="{{ old('name') }}" class="" name="name" required>
                </div>

                <div class="input-box" style="width: 100%">
                    <span class="details">اسم المشروع</span>
                    <div class="select-box">
                        <select class="" name="main_project_id" class="form-control @error('main_project_id') is-invalid @enderror" value="{{ old('main_project_id') }}" required>
                            <option selected>المشروع</option>
                            @foreach ( $main_projects as $main_project)
                            <option value="{{ $main_project->id }}">{{ $main_project->name }}</option>
                            @endforeach
                        </select>

                        @error('main_project_id')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="gender-details" style="width: 100%">
                    <input type="radio" name="code" id="dot-1" value="1" class="form-control @error('gender') is-invalid @enderror">
                    <input type="radio" name="code" id="dot-2" value="0" class="form-control @error('gender') is-invalid @enderror" checked>

                    <span class="gender-title">{{ __('متعدد الادخال') }}</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">متعدد</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">غير متعدد</span>
                        </label>
                    </div>
                    @error('gender')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
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
