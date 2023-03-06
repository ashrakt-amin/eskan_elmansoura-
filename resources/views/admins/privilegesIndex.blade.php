@extends('layouts.my_dashboard.app')

@section('content')
@if (!isset($_GET['do']))
@include('admins.privileges.privilegesTable')
@elseif ($_GET['do'] == 'addPrivilege')
@include('admins.privileges.addPrivilege')
@else
I don't have any records!
@endif

@endsection
