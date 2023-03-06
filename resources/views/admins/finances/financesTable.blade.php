<div class="card-header">
    <a href="?do=addFinance" class="warning table-buttons" href="">اضافة نظام دفع</a>
    <a href="{{ url('installmentsIndex') }}" class="secondary table-buttons">الاقساط</a>
    <a href="{{ url('paymentsIndex') }}" class="secondary table-buttons">المدفوعات</a>
    {{-- <a class="secondary table-buttons" href="{{ route('financePercentages.index') }}">نسب الدفعات</a> --}}
    <a href="{{ url('paymentKindsIndex') }}" class="secondary table-buttons">الدفعات</a>
</div>
<div class="card-body">
    <div class="table-responsive">
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
        <table width="100%">
            <thead>
                <tr>
                    <td scope="col" class="text-xl-center">id</td>
                    <td scope="col" class="text-xl-center">نظام الدفع</td>
                    <td scope="col" class="text-xl-center">عدد الشهور</td>
                    <td scope="col" class="text-xl-center">امر</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($finances as $item)

                <tr>
                    <td class="text-xl-center">{{ $item->id }}</td>
                    <td class="text-xl-center"><a href="{{ url('financeShow/'.$item->id) }}"> {{ $item->name }} </a></td>
                    <td class="text-xl-center"> {{ $item->monthes_count }}</td>
                    <td class="text-xl-center">
                        <a class="btn btn-primary" href="{{ url('editFinance/'.$item->id) }}">تعديل</a>
                     <!-- Button trigger modal -->
                     <a type="button" class="btn btn-danger text-light" data-toggle="modal" data-target="#exampleModal{{$item->id}}">حذف </a>
                    </td>
                </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> حذف القسم</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>هل تريد حذف     <strong class="danger">{{ $item->name }}</strong></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                    <a class="danger table-buttons" href="{{ url('deleteFinance/'.$item->id) }}">تاكيد الحذف</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
