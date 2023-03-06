@extends('layouts.my_dashboard.app')

@section('content')

<body>


                    <!-- AMA.MY Main page row START -->
                    <!-- AMA.MY Main page row START -->
                    <!-- AMA.MY Main page row START -->
                    <h4 class="text-lg-center text-light bg-info">المشاريع الرئيسية</h4>
                @foreach ($mainProjects as $mainProject)
                    <h5 class="text-lg-center text-dark border border-danger">
                        <a href="{{ url('show_main_project/'.$mainProject->id) }}">
                            {{ $mainProject->name }}
                        </a>
                    </h5>
                    <div class="row">
                    @if (count($mainProject->constructions) > 0 )

                        @foreach ($mainProject->constructions as $construction)
                        <div class="col-lg-3">
                            <p class="bg-primary text-lg-center">
                                <a class=" text-light" href="{{ url('showConstruction/'.$construction->id) }}">
                                    {{$construction->name}}({{$construction->property->name}})
                                </a>
                            </p>
                            <div class="row d-inline-flex">
                            @foreach ($subProperties as $subProperty)
                                @foreach ($construction->units as $unit)
                                    @php
                                        $subPropertyArray[] = ($unit->sub_property_id);
                                        array_push($subPropertyArray, $unit->sub_property_id)
                                    @endphp
                                @endforeach

                                <div class="col-lg-4" style="text-align: center;">
                                    @foreach ($construction->units as $unit)
                                    @endforeach
                                    <a href="{{url('main/filter/'.$subProperty->id.'/'.$unit->construction_id)}}" class="btn btn-outline-danger text-dark" style="font-size: 20px;">{{ $subProperty->name }}</a>
                                    {{-- <a href="{{url('main/filter/'.$subProperty->id.'/'.$unit->construction_id)}}"
                                        @if (in_array( $unit->sub_property_id, $subPropertyArray))class="btn btn-danger text-dark"
                                        @endif
                                        style="font-size: 20px;">{{ $subProperty->name }}</a> --}}
                                </div>
                            @endforeach
                            </div>
                        </div>
                        @endforeach

                    @endif
                    </div>
                @endforeach
                    <!-- AMA.MY Main page row END -->
                    <!-- AMA.MY Main page row END -->
                    <!-- AMA.MY Main page row END -->
                    <!-- AMA.MY Main page row END -->


    @endsection
