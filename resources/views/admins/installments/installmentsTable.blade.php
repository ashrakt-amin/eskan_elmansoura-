<div class="card-header">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @elseif (session('danger'))
    <div class="alert alert-danger" role="alert">
        {{ session('danger') }}
    </div>
    @endif
</div>

<div class="card-header">
    <a href="{{ url('paymentsIndex') }}" class="secondary table-buttons">المدفوعات</a>
    <a class="secondary table-buttons" href="{{ route('financePercentages.index') }}">نسب الدفعات</a>
    <a href="{{ url('financesIndex') }}" class="secondary table-buttons">انظمة السداد</a>
    <a href="{{ url('paymentKindsIndex') }}" class="secondary table-buttons">الدفعات</a>
</div>
<!--------- المشاريع --------->
<!--------- المشاريع --------->
<div class="card-body">
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <td>الوحدة</td>
                    <td>المبنى</td>
                    <td>العميل</td>
                    <td>تاريخ الحركة</td>
                    <td>شهر</td>
                    <td> قيمة القسط</td>
                </tr>
            </thead>
            <tbody>
                @if (count($installments) >0 )

                @foreach ($installments as $installment)

                <tr>
                    <td><a href="{{ url('unitShow/'.$installment->unit_id) }}"> {{ $installment->unit->name }} </a></td>
                    <td><a href="{{ route('showConstruction', ['id'=>$installment->unit->construction_id]) }}"> {{ $installment->unit->construction->name }} </a></td>
                    <td><a href="{{ url('customerShow/'.$installment->customer_id) }}"> {{ $installment->customer->name }} </a></td>
                    <td><a href="">{{ $installment->created_at }}</a></td>
                    <td>{{ $installment->installment_month }}</td>
                    <td>{{ $installment->installment_value }}</td>
                </tr>

                @endforeach
                <tr>
                    <td class="sum" colspan="4">اجمالي المدفوعات</td>
                    <td class="sum">{{ $installment->sum('installment_value') }}</td>
                </tr>

                @else
                <tr>
                    <td colspan="5">لا يوجد بعد</td>
                </tr>
                @endif


            </tbody>
        </table>
    </div>
</div>
<!--######## المشاريع ###########-->
<!--######## المشاريع ###########-->

