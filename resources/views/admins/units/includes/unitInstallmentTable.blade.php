
<div class="card-header">
    <p>الاقساط</p>
</div>
<div class="table-responsive">
    <table width="100%" style="margin-top: 5px">
        <thead>
            <tr>
                <td>القسط</td>
                <td> الشهر</td>
                <td>المتبقي</td>
                <td>باقي الأقساط </td>
                <td>تاريخ </td>
                <td>وقت </td>
                <td>امر</td>
            </tr>
        </thead>
        <tbody>
            @php
                $installmentsArray = array();
                $installments = array($unit->installments);
                foreach ($unit->installments as $item) {
                    array_push($installmentsArray, $item);
                }
                asort($installmentsArray);
            @endphp
            @foreach ($installmentsArray as $installment)
            <tr>
                <td>{{ $installment->installment_value}}</td>
                <td>{{ $installment->installment_month}}</td>
                <td>{{ $installment->residual->all_residuals}}</td>
                <td>{{ $installment->residual_installments}}</td>
                <td>{{ $installment->created_at->format('Y-m-d') }}</td>
                <td>{{ $installment->created_at->format('h:i A') }}</td>
                <td>
                    <a class="btn btn-primary" href="{{ url('editInstallment/'.$installment->id) }}">تعديل</a>
                    <!-- Button trigger modal -->
                    <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#installmentexampleModal{{$installment->id}}">حذف </a>
                </td>
            </tr>
                <!-- Modal -->
                <div class="modal fade" id="installmentexampleModal{{$installment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> حذف القسم</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>هل تريد حذف <strong class="danger">{{ __('القسط') }}</strong></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                <a class="danger table-buttons" href="{{ route('deleteInstallment', ['installment' =>$installment->id]) }}">تاكيد الحذف</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
