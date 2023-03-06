@extends('layouts.my_dashboard.app')

@section('content')

<div class="form-body">
    <div class="form-container">
        <div class="title">تعديل بيانات عميل</div>
        @if (session('status'))
        <div class="alert-danger">{{ session('status') }}</div>
        @endif
        {{-- <form action="{{ route('customers.update', ['id'=>$customers->id]) }}" method="POST" enctype="multipart/form-data"> --}}
        <form action="{{ route('updateCustomer', ['id'=>$customers->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="user-details">

                <div class="input-box">
                    <label for="">الاسم الاول</label>
                    <input type="text" name="name" value="{{ $customers->name }}" placeholder="الاسم الاول" required>
                </div>

                <div class="input-box">
                    <label for="">الاسم الاوسط</label>
                    <input type="text" name="mid_name" value="{{ $customers->mid_name }}" placeholder="الثاني والثالث" >
                </div>

                <div class="input-box">
                    <label for=""> اللقب</label>
                    <input type="text" name="last_name" value="{{ $customers->last_name }}" placeholder="اللقب" required>
                </div>

                <div class="input-box">
                    <label for="">السن</label>
                    <input type="text" name="age" value="{{ $customers->age }}" placeholder="السن اساسي">
                </div>

                <div class="input-box">
                    <label for="">الهاتف</label>
                    <input type="text" name="phone" value="{{ $customers->phone }}" placeholder="الهاتف اساسي" >
                </div>

                <div class="input-box">
                    <label for="">البريد الاكتروني</label>
                    <input type="email" name="email" value="{{ strpos($customers->email, 'null') !== false ? '' : $customers->email }}" placeholder="غير اساسي">
                </div>

                <div class="input-box">
                    <label for="">الرقم القومي</label>
                    <input type="text" name="national_id" value="{{ $customers->national_id }}" placeholder="الرقم القومي">
                </div>

                <div class="input-box">
                    <label for="">بيانات اضافية</label>
                    <input type="text" name="additional_info" value="{{ $customers->additional_info }}">
                </div>

                <div class="input-box">
                    <label for="">صورة العميل</label>
                    <input type="file" name="image" value="{{ $customers->image }}">
                </div>

                <div class="input-box">
                    <input type="hidden" class="form-control" name="privilege_id" value="0">
                </div>

            </div>
            <div class="gender-details">
                <input type="radio" name="gender" id="dot-1" value="male" {{ $customers->gender == 'male' ? 'checked' : '' }}>
                <input type="radio" name="gender" id="dot-2" value="female" {{ $customers->gender == 'female' ? 'checked' : '' }}>

                <span class="gender-title">gender</span>
                <div class="category">
                    <label for="dot-1">
                        <span class="dot one"></span>
                        <span class="gender">Male</span>
                    </label>
                    <label for="dot-2">
                        <span class="dot two"></span>
                        <span class="gender">Female</span>
                    </label>
                </div>
            </div>
            <div class="form-button">
                <input type="submit" value="تعديل بيانات عميل">
            </div>
        </form>
    </div>
</div>

@endsection
