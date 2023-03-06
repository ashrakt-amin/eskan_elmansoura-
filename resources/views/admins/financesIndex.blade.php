@extends('layouts.my_dashboard.app')

@section('content')
@if (!isset($_GET['do']))
@include('admins.finances.financesTable')

@elseif ($_GET['do'] == 'addFinance')
@include('admins.finances.addFinance')

@else
I don't have any records!
@endif

@endsection
