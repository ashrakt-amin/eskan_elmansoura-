@extends('layouts.my_dashboard.app')

@section('content')


    <a href="{{ url('main/new') }}" class="mb-2 btn btn-secondary text-dark text-bold myText-button">الرئيسية الجديدة </a>


                    <!-- AMA.MY Main page row START -->
                    <!-- AMA.MY Main page row START -->
                    <!-- AMA.MY Main page row START -->
                    <h4 class="text-lg-center text-light bg-info">المشاريع الرئيسية</h4>
        @foreach ($properties as $property)
                {{-- {{ dd($property->mainProjects) }} --}}
                @foreach ($property->mainProjects as $mainProject)
                {{-- {{ dd($mainProject->name) }} --}}
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
                                    {{ $construction->name }}
                                </a>
                            </p>
                            <div class="row">
                                {{-- @foreach ($allLevels as $level)                                                                   --}}
                                    @foreach ($construction->units as $unit)

                                <div    @if ($unit->status == "تعاقد")
                                    class="col-3 bg-danger text-lg-center border border-primary" style="width :10rem;height :3rem"
                                        @elseif($unit->status == "خالية")
                                    class="col-3 bg-success text-lg-center border border-primary" style="width :10rem;height :3rem"
                                        @elseif($unit->status == "محجوزة")
                                    class="col-3 bg-warning text-lg-center border border-primary" style="width :10rem;height :3rem"
                                        @else
                                    class="col-3 text-lg-center border border-primary" style="width :10rem;height :3rem"
                                        @endif
                                    >
                                    <h5 class="">
                                        <a class="text-dark p-2" href="{{ url('unitShow/'.$unit->id) }}">
                                        {{$unit->name}}
                                        </a>
                                    </h5>
                                    {{-- @if (!empty($unit->customers->name))
                                        <a class="text-dark" href="{{ url('customerShow/'.$unit->customers->id) }}">
                                            {{$unit->customers->name}}
                                        </a>
                                    @endif --}}


                                </div>
                                    @endforeach
                                {{-- @endforeach --}}
                            </div>


                        </div>

                        @endforeach
                    @endif
                    </div>
                @endforeach
            @endforeach
                    <!-- AMA.MY Main page row END -->
                    <!-- AMA.MY Main page row END -->
                    <!-- AMA.MY Main page row END -->


@endsection
