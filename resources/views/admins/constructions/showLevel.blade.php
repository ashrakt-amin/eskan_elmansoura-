@extends('layouts.my_dashboard.app')

@section('content')
<div class="row">
<div class="col-lg-6">
    <table class="table table-light table-bordered">
        <thead>
        <tr>
            <th scope="col" class="text-xl-center">name</th>

        </tr>
        </thead>
        <tbody>

@foreach ($level as $item)

        <tr>
            <th scope="row" class="text-xl-center" class="text-xl-center">
                <a href="{{ url('singleLevel/'.$item->id) }}">
                    {{ $item->name }}
                </a>
            </th>
            <th scope="row" class="text-xl-center" class="text-xl-center">
                <a href="{{ url('showLevels/'.$item->id) }}"></a>
            </th>

        </tr>
@endforeach
        </tbody>
    </table>
</div>
<div class="col-lg-4 ml-1">

        @for ($i = 1; $i < $constructions->levels_count+1; $i++)
        <div class="">
            <h4>
                <a class="btn btn-secondary" href="{{route('showLevel', ['id'=>$i-1, 'constructions'=>$constructions->id])}}">الدور {{ $i }}</a>
            </h4>
        </div>
        @endfor
</div>
</div>
@endsection
