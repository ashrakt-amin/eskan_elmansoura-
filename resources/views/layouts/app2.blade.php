<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fontsGooglePoppins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/boxicons.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/css/dashboardStyle.css') }}" rel="stylesheet"> --}}
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
</head>
<body>
            <label class="">
                <input type="checkbox" id="checkbox">
                <div class="toggle">
                    <span class="top_line common"></span>
                    <span class="mid_line common"></span>
                    <span class="bot_line common"></span>
                </div>
                <div class="slide">
                    <h1>MENU</h1>
                    <ul>
                        <li>
                            <i class="fas fa-tv"></i> الرئيسية
                            <ul class="menu_bar">
                                <li class="nav-link"><a href="{{ url('managerFundIndex') }}">المدير </a></li>
                                <li class="nav-link"><a href="{{ url('index') }}">الرئيسية </a></li>
                            </ul>
                        </li>
                        <li>
                            <i class="fas fa-tv"></i> العملاء
                            <ul class="menu_bar">
                                <li class="nav-link"><a href="{{ url('customerIndex') }}">العملاء </a></li>
                                <li class="nav-link"><a href="{{ url('installmentsIndex') }}">الاقساط</a></li>
                                <li class="nav-link"><a href="{{ url('paymentsIndex') }}">الدفعات</a></li>
                            </ul>
                        </li>
                        <li>
                            <i class="fas fa-tv"></i> الوحدات
                            <ul class="menu_bar">
                                <li class="nav-link"><a href="{{ url('unitsIndex') }}">الوحدات</a></li>
                                <li class="nav-link"><a href="{{ url('constructionsIndex') }}">المنشئات</a></li>
                                <li class="nav-link"><a href="{{ url('sites/index') }}">الموقع</a></li>
                                <li class="nav-link"><a href="{{ url('levelsIndex') }}">الطوابق</a></li>
                            </ul>
                        </li>
                        <li>
                            <i class="fas fa-user"></i> الدفعات
                            <ul class="menu_bar">
                                <li class="nav-link"><a href="{{ url('financePercentages/index') }}">نسبة الدفعات</a></li>
                                <li class="nav-link"><a href="{{ url('paymentKindsIndex') }}">انواع الدفعات</a></li>
                                <li class="nav-link"><a href="{{ url('financesIndex') }}">انظمة الدفع</a></li>
                            </ul>
                        </li>
                        <li>
                            <i class="fas fa-heart"></i> الرئيسية
                            <ul class="menu_bar">
                                <li class="nav-link"><a href="{{ url('subProperties/') }}">أقسام الوحدات</a></li>
                                <li class="nav-link"><a href="{{ url('main_projectsIndex') }}">المشاريع الرئيسية</a></li>
                                <li class="nav-link"><a href="{{ url('propertiesIndex') }}">الاقسام الرئيسية</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </label>

            <section class="home">
                <div class="main offset-1">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </section>

</body>
</html>
