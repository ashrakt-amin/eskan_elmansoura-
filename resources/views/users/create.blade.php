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
<div class="form-body">
    <div class="form-container">
        <div class="title">مستخدم جديد</div>
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="user-details">
                <div class="input-box">
                    <span class="details">{{ __('اسم المستخدم') }}</span>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('الاسم الاوسط') }}</span>
                    <input id="mid_name" type="text" class="form-control @error('mid_name') is-invalid @enderror" name="mid_name" value="{{ old('mid_name') }}"  autocomplete="mid_name" autofocus>

                    @error('mid_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('القب') }}</span>
                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}"  autocomplete="last_name" autofocus>

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('السن') }}</span>
                    <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}"  autocomplete="age" autofocus>

                    @error('age')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('الهاتف') }}</span>
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}"  autocomplete="phone" autofocus>

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('البريد الالكتروني') }}</span>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('كلمة المرور') }}</span>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('الصلاحية') }}</span>
                    <div class="select-box">
                        <select class="form-control" name="privilege_id" class="form-control @error('privilege_id') is-invalid @enderror">
                            <option value="0" selected>{{ __('الصلاحية') }}</option>
                            @if (count($privileges) > 0 )
                            @foreach ( $privileges as $privilege)
                            <option value="{{ $privilege->id }}">{{ $privilege->name }}</option>
                            @endforeach
                            @endif
                        </select>

                        @error('privilege_id')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="gender-details" style="width: 100%">
                    <input type="radio" name="gender" id="dot-1" value="male" class="form-control @error('gender') is-invalid @enderror">
                    <input type="radio" name="gender" id="dot-2" value="female" class="form-control @error('gender') is-invalid @enderror">

                    <span class="gender-title">{{ __('الجنس') }}</span>
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
        </form>
    </div>
</div>

        @endsection
