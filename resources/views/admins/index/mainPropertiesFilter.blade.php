
@extends('layouts.my_dashboard.app')

@section('content')

<body>
    <h1 class="bg-danger text-lg-center"> تحت الانشاء </h1>

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Hello, <span>Welcome Here</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">
                    <!-- AMA.MY Main page row START -->
                    <!-- AMA.MY Main page row START -->
                    <!-- AMA.MY Main page row START -->
@if (count($units) > 0)


@foreach ($units as $unit)
@endforeach
@foreach ($subProperties as $subProperty)
                <div class="row d-inline-flex">
                    <div class="col-lg-12">
                        <a href="{{url('main/filter/'.$subProperty->id.'/'.$unit->construction_id)}}">{{$subProperty->name}}</a>
                    </div>
                </div>

@endforeach
                    <h4 class="text-lg-center text-light bg-info">المشاريع الرئيسية</h4>
                    <h5 class="text-lg-center text-dark border border-danger">
                        <a href="{{ url('show_main_project/'.$unit->mainProject_id) }}">
                            {{ $unit->mainProject->name }}
                        </a>
                    </h5>
                    <div class="row">

                        <div class="col-lg-12">
                            <p class="bg-primary text-lg-center">
                                <a class=" text-light" href="{{ url('showConstruction/'.$unit->construction_id) }}" style="font-size: 30px">
                                    {{$unit->construction->name}}
                                </a>
                                <a class=" text-light" href="{{ url('main/filter/'.$subProperty->id.'/'.$unit->construction_id)}}) }}" style="font-size: 30px">
                                    {{$unit->property->name}}
                                </a>
                            </p>
                            <div class="row">
                                @foreach ($units as $unit)

                                <div @if ($unit->status == "تعاقد")
                                    class="col-3 bg-danger text-lg-center border border-primary" style="width :10rem;height :15rem"
                                    @elseif($unit->status == "خالية")
                                    class="col-3 bg-success text-lg-center border border-primary" style="width :10rem;height :15rem"
                                    @elseif($unit->status == "محجوزة")
                                    class="col-3 bg-warning text-lg-center border border-primary" style="width :10rem;height :15rem"
                                    @else
                                    class="col-3 text-lg-center border border-primary" style="width :10rem;height :15rem"
                                    @endif
                                    >
                                    <h5 class="">
                                        <a class="text-dark p-2" href="{{ url('unitShow/'.$unit->id) }}">
                                        {{'رقم الوحدة ( '}}{{$unit->name}}{{' )'}}
                                        </a>
                                    </h5>
                                    <h5 class="">
                                        <a class="text-dark p-2" href="{{ url('unitShow/'.$unit->id) }}">
                                        {{$unit->unit_price}}
                                        </a>
                                    </h5>
                                    <h5 class="">
                                        <a class="text-dark p-2" href="{{ url('unitShow/'.$unit->id) }}">
                                        {{$unit->level->name}}
                                        </a>
                                    </h5>
                                    <h5 class="">
                                        <a class="text-dark p-2" href="{{ url('unitShow/'.$unit->id) }}">
                                        {{$unit->space}}
                                        </a>
                                    </h5>
                                    <h5 class="">
                                        <a class="text-dark p-2" href="{{ url('unitShow/'.$unit->id) }}">
                                        {{$unit->site->name}}
                                        </a>
                                    </h5>
                                    <h5 class="">
                                        <a class="text-dark p-2" href="{{ url('unitShow/'.$unit->id) }}">
                                        {{$unit->status}}
                                        </a>
                                    </h5>
                                    {{-- @if (!empty($unit->customers->name))
                                        <a class="text-dark" href="{{ url('customerShow/'.$unit->customers->id) }}">
                                            {{$unit->customers->name}}
                                        </a>
                                    @endif --}}


                                </div>
@endforeach
@else
                                <h1>{{'لا يوجد وحدات تحت هذا القسم في هذه المنشأة'}}</h1>
@endif
                            </div>


                        </div>


                    </div>
                    <!-- AMA.MY Main page row END -->
                    <!-- AMA.MY Main page row END -->
                    <!-- AMA.MY Main page row END -->
                    <!-- AMA.MY Main page row END -->











                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer">
                                <p>2018 © Admin Board. - <a href="#">example.com</a></p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @endsection
