@extends('layouts.my_dashboard.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h1>
            {{-- {{ $property->name }} --}}
        </h1>
    </div>


    <div class="card-body">
        <div class="table-responsive">
            <table width="100%">
                <thead>
                    <tr>
                        <td>المشروع</td>
                        <td>القسم الاساسي للمشروع</td>
                        <td>اقسام مباني المشروع</td>
                        {{-- <td>مباني تحت القسم</td> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($constructions->unique('main_project_id') as $construction)
                    <tr>
                        <td><a href="{{ route('show_main_project', ['id'=>$construction->main_project_id]) }}" class="btn btn-outline-success ml-1">{{ $construction->mainProject->name }}</a></td>
                        <td><a href="{{ route('searchProperties', ['id'=>$construction->mainProject->property_id, 'main_project'=>$construction->main_project_id]) }}" class="btn btn-outline-success ml-1">{{ $construction->mainProject->property->name }}</a></td>
                        <td class="d-flex">
                            @if (count($main_projects) > 0)
                            @foreach ($main_projects as $main_project)

                            @forelse ($main_project->constructions->unique('property_id') as $construction_property)
                            <a href="{{ route('searchProperties', ['id'=>$construction_property->property_id, 'main_project'=>$construction_property->main_project_id]) }}" class="btn btn-outline-success ml-1">{{ $construction_property->property->name }}</a>
                            @empty
                            <a>لا يوحد وحدات</a>
                            @endforelse
                            @endforeach
                            @else
                            <a href="{{ route('searchProperties', ['id'=>$construction->property_id, 'main_project'=>$construction->property_id]) }}" class="btn btn-outline-success m-2 p-2">{{ $construction->property->name }}</a>
                            @endif
                        </td>
                        {{-- <td><a href="{{ url('show_main_project/'.$construction->main_project_id) }}" class="btn btn-outline-success m-2 p-2">{{ count($constructions) }}</a></td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
