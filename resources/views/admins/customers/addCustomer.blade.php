@extends('layouts.my_dashboard.app')

@section('content')

<div class="form-body">
    <div class="form-container">
        <div class="title">اضافة عميل</div>
        @if (session('status'))
        <div class="alert-danger">{{ session('status') }}</div>
        @endif
        <form action="{{ url('insertCustomer') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="user-details">

                <div class="input-box">
                    <label for="">الاسم الاول</label>
                    <input type="text" name="name"  class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="الاسم الاول" required>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="">الاسم الاوسط</label>
                    <input type="text" name="mid_name"  class="form-control @error('mid_name') is-invalid @enderror" value="{{ old('mid_name') }}" placeholder="الثاني والثالث" >

                    @error('mid_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for=""> اللقب</label>
                    <input type="text" name="last_name"  class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="اللقب" required>

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="">السن</label>
                    <input type="text" name="age"  class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" placeholder="السن ">

                    @error('age')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="">الهاتف</label>
                    <input type="text" name="phone"  class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="الهاتف اساسي" >

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="">البريد الاكتروني</label>
                    <input type="email" name="email"  class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="غير اساسي">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="">الرقم القومي</label>
                    <input type="text" name="national_id"  class="form-control @error('national_id') is-invalid @enderror" value="{{ old('national_id') }}" placeholder="الرقم القومي">

                    @error('national_id')
                        <span class="invalid-feedback" role="alert">
                            @if (!empty($message))
                            @php
                                $item = (\App\Models\Customer::find($message))
                            @endphp
                            @if (!empty($item))
                            <strong><a href="{{ route('customerShow', ['id'=>$message]) }}" class="text-light">{{ $item->name.' '.$item->last_name }}</a></strong>
                            @else
                            <strong>{{ $message }}</strong>
                            @endif
                            @endif
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="">بيانات اضافية</label>
                    <input type="text" name="additional_info" value="{{ old('additional_info') }}">
                </div>

                <div class="input-box">
                    <label for="">صورة العميل</label>
                    <input type="file" name="image" value="{{ old('name') }}">
                </div>

                <div class="input-box">
                    <input type="hidden" class="form-control" name="privilege_id" value="0">
                </div>

            </div>
            <div class="gender-details">
                <input type="radio" name="gender" id="dot-1" value="male">
                <input type="radio" name="gender" id="dot-2" value="female">

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
                    <input type="submit" value="اضافة عميل">
                </div>
        </form>
    </div>
</div>

@endsection
