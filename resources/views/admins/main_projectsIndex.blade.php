@extends('layouts.my_dashboard.app')

@section('content')
@if (!isset($_GET['do']))
@include('admins.main_projects.main_projectsTable')
@elseif ($_GET['do'] == 'add_main_project')
@include('admins.main_projects.add_main_project')
@else
I don't have any records!
@endif

@endsection
