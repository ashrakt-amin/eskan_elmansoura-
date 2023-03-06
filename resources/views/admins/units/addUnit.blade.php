
@extends('layouts.my_dashboard.app')

@section('content')

<div class="form-body">
    <div class="">
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
            @elseif (session('danger'))
            <div class="alert alert-danger" role="alert">
                {{ session('danger') }}
            </div>
            @endif
    </div>
    <div class="form-container">
        <div class="title">اضافة وحدة</div>
        <form action="">
            <div class="user-details">
                <div class="input-box">
                    <span class="details">full</span>
                    <input type="text" placeholder="Enter some data" value="" required>
                </div>
                <div class="input-box">
                    <span class="details">full1</span>
                    <input type="text" placeholder="Enter some data" value="" required>
                </div>
                <div class="input-box">
                    <span class="details">full2</span>
                    <input type="text" placeholder="Enter some data" value="" required>
                </div>
                <div class="input-box">
                    <span class="details">full2</span>
                    <input type="text" placeholder="Enter some data" value="" required>
                </div>
            </div>
            <div class="gender-details">
                <input type="radio" name="gender" id="dot-1">
                <input type="radio" name="gender" id="dot-2">
                <input type="radio" name="gender" id="dot-3">
                <span class="gender-title">gender</span>
                <div class="category">
                    <label for="dot-1">
                        <span class="dot one"></span>
                        <span class="gender">m</span>
                    </label>
                    <label for="dot-2">
                        <span class="dot two"></span>
                        <span class="gender">f</span>
                    </label>
                    <label for="dot-3">
                        <span class="dot three"></span>
                        <span class="gender">no</span>
                    </label>
                </div>
            </div>
            <div class="form-button">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
</div>


@endsection
