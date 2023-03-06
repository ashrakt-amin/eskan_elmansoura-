@extends('layouts.my_dashboard.app')

@section('content')

        <div class="card-header">
            <h1 class="text-success font-italic text-center bg-dark font-weight-bold">Add Manager Fund</h1>
        </div>
        <div class="card-body">
            <form action="{{ url('insertManagerFund') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">


                    <div class="col-md-6 mb-3">
                        <div>
                            <h5>
                                <label for="">الحركة</label>
                            </h5>
                        </div>
                        <div>
                            <label class="form-check-label mr-5" for="exampleRadios2">
                                <input class="form-check-input mr-2" type="radio" name="kind" id="exampleRadios2" value="0">استلام
                            </label>

                            <label class="form-check-label mr-5" for="exampleRadios2">
                                <input class="form-check-input mr-2" type="radio" name="kind" id="exampleRadios2" value="1">صرف
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
                                <input class="form-check-input mr-2" type="radio" name="category" id="exampleRadios2" value="0">شخصي
                            </label>

                            <label class="form-check-label mr-5" for="exampleRadios2">
                                <input class="form-check-input mr-2" type="radio" name="category" id="exampleRadios2" value="1">المؤسسة
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5>
                            <label for="">المبلغ</label>
                        </h5>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="value" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5>
                            <label for="">تعليق</label>
                        </h5>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="comment" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5>
                            <label for="">اليوم</label>
                        </h5>
                        <input  type="date" class="form-control m-1" id="date" type="date" name="date_date" style="width: 200px">
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>

@endsection
