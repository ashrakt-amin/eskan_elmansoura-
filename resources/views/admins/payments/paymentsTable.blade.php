
<div class="card-body">
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
</div>
<div class="card-header">
    <a class="primary table-buttons" href="{{ route('commissions.index') }}">{{ __('العمولات') }}</a>
</div>
<div class="card-header">
    <a href="{{ route('payments.search', ['day'=>'today']) }}" class="secondary table-buttons">مدفوعات اليوم</a>
    <a href="{{ route('payments.search', ['day'=>'week']) }}" class="secondary table-buttons">مدفوعات الاسبوع</a>
    <a href="{{ route('payments.search', ['day'=>'month']) }}" class="secondary table-buttons">مدفوعات الشهر</a>
    <a href="{{ url('installmentsIndex') }}" class="secondary table-buttons">الاقساط</a>
    <a class="secondary table-buttons" href="{{ route('financePercentages.index') }}">نسب الدفعات</a>
    <a href="{{ url('financesIndex') }}" class="secondary table-buttons">انظمة السداد</a>
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
                    <td>المدفوع</td>
                    <td>تاريخ الحركة</td>
                    <td>الدفعة</td>
                    <td> قيمة الدفعة</td>
                </tr>
            </thead>
            <tbody>
                @if (count($payments) >0 )

                @foreach ($payments as $payment)

                <tr>
                    <td><a href="{{ url('unitShow/'.$payment->unit_id) }}"> {{ $payment->unit->name }}</a></td>
                    <td><a href="{{ url('showConstruction/'.$payment->unit->construction_id) }}">{{ $payment->unit->construction->name }}</a></td>
                    <td><a href="{{ url('customerShow/'.$payment->customer_id) }}"> {{ $payment->customer->name }} </a></td>
                    <td><a>{{ $payment->residual->all_residuals }}</a></td>
                    <td><a href="">{{ $payment->created_at }}</a></td>
                    <td><a>{{ $payment->payment_kind_id != '999999999' ? $payment->paymentKind->name : 'دفعة استرداد' }}</a></td>
                    <td><a>{{ $payment->payment_value }}</a></td>
                </tr>

                @endforeach
                <tr>
                    <td class="sum" colspan="6">اجمالي المدفوعات</td>
                    <td class="sum">{{ $payments->sum('payment_value') }}</td>
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

