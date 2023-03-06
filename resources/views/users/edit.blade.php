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
        <form action="{{ route('users.update', ['user'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="user-details">
                <div class="input-box">
                    <span class="details">{{ __('اسم المستخدم') }}</span>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}"  autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('الاسم الاوسط') }}</span>
                    <input id="mid_name" type="text" class="form-control @error('mid_name') is-invalid @enderror" name="mid_name" value="{{ $user->mid_name }}"  autocomplete="mid_name" autofocus>

                    @error('mid_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('اللقب') }}</span>
                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}"  autocomplete="last_name" autofocus>

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('السن') }}</span>
                    <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ $user->age }}"  autocomplete="age" autofocus>

                    @error('age')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('الهاتف') }}</span>
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}"  autocomplete="phone" autofocus>

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-box">
                    <span class="details">{{ __('البريد الالكتروني') }}</span>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}"  autocomplete="email">

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
                    <span class="details">{{ __('تاكيد كلمة المرور') }}</span>
                    <input id="password-confirm" type="password" class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation"  autocomplete="new-password">

                    @error('password-confirm')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- <div class="input-box">
                    <span class="details">{{ __('تاكيد كلمة المرور') }}</span>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div> --}}
                @if (Auth::user()->privilege_id == 1)
                <div class="input-box">
                    <span class="details">{{ __('الصلاحية') }}</span>
                    <div class="select-box">
                        <select class="" name="privilege_id" class="form-control @error('privilege_id') is-invalid @enderror">
                            <option value="0" selected>{{ __('الصلاحية') }}</option>
                            @if (count(\App\Models\Privilege::all()) > 0 )
                            @foreach ( App\Models\Privilege::all() as $privilege)
                            <option {{ $user->privilege_id == $privilege->id ? 'selected' : '' }} value="{{ $privilege->id }}">{{ $privilege->name }}</option>
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
                @endif
                <div class="gender-details" style="width: 100%">
                    <input type="radio" name="gender" id="dot-1" value="male" @error('gender') is-invalid @enderror" {{ $user->gender == 'male' ? 'checked' : '' }}>
                    <input type="radio" name="gender" id="dot-2" value="female" @error('gender') is-invalid @enderror" {{ $user->gender == 'female' ? 'checked' : '' }}>

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
                <input type="submit" value="تعديل">
            </div>

        </form>
    </div>
</div>

        @endsection
