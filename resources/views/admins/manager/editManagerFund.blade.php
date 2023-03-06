@extends('layouts.my_dashboard.app')

@section('content')


        <div class="card-header">
            <h1 class="text-success font-italic text-center bg-dark font-weight-bold">Edit Manager Fund</h1>
        </div>
        <div class="card-body">
            <form action="{{ url('/updateManagerFund/'.$managerFund->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <div>
                            <h5>
                                <label for="">الحركة</label>
                            </h5>
                        </div>
                        <div>
                            <label class="form-check-label mr-5" for="exampleRadios2">
                                <input class="form-check-input mr-2" {{ $managerFund->kind == 0 ? 'checked' : '' }} type="radio" name="kind" id="exampleRadios2" value="0">وارد
                            </label>

                            <label class="form-check-label mr-5" for="exampleRadios2">
                                <input class="form-check-input mr-2" {{ $managerFund->kind == 1 ? 'checked' : '' }} type="radio" name="kind" id="exampleRadios2" value="1">منصرف
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div>
                            <h5>
                                <label for="">نوع الحركة</label>
                            </h5>
                        </div>
                        <div>
                            <label class="form-check-label mr-5" for="exampleRadios2">
                                <input class="form-check-input mr-2" {{ $managerFund->category == 0 ? 'checked' : '' }} type="radio" name="category" id="exampleRadios2" value="0">شخصي
                            </label>

                            <label class="form-check-label mr-5" for="exampleRadios2">
                                <input class="form-check-input mr-2" {{ $managerFund->category == 1 ? 'checked' : '' }} type="radio" name="category" id="exampleRadios2" value="1">المؤسسة
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5>
                            <label for="">المبلغ</label>
                        </h5>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="value" value="{{ $managerFund->value }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5>
                            <label for="">تعليق</label>
                        </h5>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="comment" value="{{ $managerFund->comment }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5>
                            <label for="">اليوم</label>
                        </h5>
                        <input  type="date" class="form-control m-1" id="date" type="date" name="date_date" style="width: 200px">
                        <input  type="text" class="form-control m-1" id="date" type="date" value="{{ $managerFund->created_at }}" style="width: 200px">
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>


@endsection
