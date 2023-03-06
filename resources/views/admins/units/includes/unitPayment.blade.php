                    <!--------- المدفوعات --------->
                    <!--------- المدفوعات --------->

                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td>المدفوع</td>
                                        <td>نوع الدفعة</td>
                                        <td>الاجمالي </td>
                                        <td>المتبقي</td>
                                        <td>التاريخ </td>
                                        <td>الوقت </td>
                                        <td>أمر</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payments as $payment)

                                    @if (count($payments) == 0)
                                    <tr>
                                        <td><a>لا يوجد  </a> </td>
                                    @else
                                        <td>{{ $payment->payment_value}}</td>
                                        <td>{{ $payment->paymentKind->name}}</td>
                                        <td>{{ $payment->unit->unit_price - $payment->residual->all_residuals}}</td>
                                        <td>{{$payment->residual->all_residuals}} </td>
                                        <td>{{ $payment->created_at->format('Y-m-d')}}</td>
                                        <td>{{ $payment->created_at->format('h:i A')}}</td>
                                        <td>
                                            <a class="info table-buttons " href="{{ url('editPayment/'.$payment->id) }}">تعديل</a>
                                            <a class="danger table-buttons " href="{{ url('deletePayment/'.$payment->id) }}">حذف</a>
                                        </td>
                                    @endif
                                    </tr>

                                    @empty

                                    <tr>
                                        <td></td>
                                    </tr>

                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    <!--######## المدفوعات ###########-->
                    <!--######## المدفوعات ###########-->


