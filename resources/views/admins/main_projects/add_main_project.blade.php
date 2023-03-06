@extends('layouts.my_dashboard.app')

@section('content')

<div class="card-header">
    <div></div>
    <h1 class="">اضافة مشروع جديد</h1>
    <div></div>
</div>

<div class="card">
    <div class="form-body">
        <div class="form-container">
            <form action="{{ url('insert_main_project') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="user-details">
                    <div class="input-box" style="width: 100%">
                        <span class="details">اسم المشروع</span>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
                    </div>

                    <div class="input-box" style="width: 100%">
                        <span class="details">قسم </span>
                        <div class="input-box w-100">
                            <div class="select-box">
                                <select  name="property_id" id="" class="form-control @error('property_id') is-invalid @enderror" name="name" value="{{ old('property_id') }}">
                                    <option value="">اختر القسم</option>
                                    @foreach ($properties as $property)
                                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                                    @endforeach
                                </select>

                                @error('property_id')
                                <span class="invalid-feedback" role="alert">
                                    <stron>{{ $message }}</stron>
                                </span>
                                @enderror
                            </div>
                        </div>
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
</div>

@endsection
