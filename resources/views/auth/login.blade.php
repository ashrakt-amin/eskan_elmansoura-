<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Eskan Dash Board</title>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landin/gs/line-awesome/font-awesome-line-awesome/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('my_dashboard/line-awesome/css/line-awesome-font-awesome.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">

        <link rel="stylesheet" href="{{ asset('my_dashboard/style.css') }}">

    </head>
    <body>
        <div class="container-fluid p-1">
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
                    <a class=" text-warning" href="{{ url('register') }}">تسجيل جديد</a>
                    <div class="title">{{ __('تسجيل الدخول') }}</div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="user-details">
                            <div class="input-box w-100 text-center">
                                <span class="details">{{ __('البريد الالكتروني') }}</span>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="input-box w-100 text-center">
                                <span class="details">{{ __('الرقم السري') }}</span>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!------------------------------------- Submit ------------------------------------->
                        <div class="form-button">
                            <input type="submit" value="{{ __('تسجيل الدخول') }}">
                        </div>

                        <div class="gender-details" style="width: 100%">
                                {{-- <div class="form-check text-warning">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                    @if (Route::has('password.request'))
                                    <a class=" text-warning" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                    @endif
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
