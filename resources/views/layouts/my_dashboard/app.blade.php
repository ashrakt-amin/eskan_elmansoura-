<!DOCTYPE html>
    <html lang="en" dir="ltr">
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


        @include('layouts.my_dashboard.includes.sidebar')

        <!-- main content -->
        <!-- main content -->
        <!-- main content -->

        <div class="main-content">

        @include('layouts.my_dashboard.includes.header')

            <!-- Main -->
            <main>
                @yield('content')
            </main>

        </div>


        @include('layouts.my_dashboard.includes.scripts')

    </body>
</html>
