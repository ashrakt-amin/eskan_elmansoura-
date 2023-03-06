
   @extends('layouts.my_dashboard.app')

   @section('content')

            <div class="form-body">
                <div class="form-container">
                        <div class="title">اضافة مجموعة وحدات</div>
                        <div class="card-body">
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
                            @elseif (session('warning'))
                            <div class="alert alert-warning" role="alert">
                                {{ session('warning') }}
                            </div>
                            @elseif (session('status'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                            @endif
                        </div>
                        <form action="{{ url('unitMultipleStore') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card-header">
                                <span class="warning">{{$property->name}}</span>
                                <span class="warning">{{ $main_project->name}}</span>
                                <span class="warning">{{ $construction->name}}</span>
                            </div>
                            @if (!$rows)
                                {{$rows=2}}
                            @endif
                            @for ($i = 0; $i < $rows; $i++)
                                @include('admins.units.includes.insertingUnitsRow')
                            @endfor
                            <div class="form-button">
                                <input type="submit" value="اضافة">
                            </div>
                        </form>
                    </div>
                </div>




    @endsection
