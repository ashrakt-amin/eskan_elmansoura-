                    <!---------  --------->
                    <!---------  --------->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td>{{ __('مشروع') }}</td>
                                        <td>{{ __('من تاريخ') }}</td>
                                        <td>{{ __('الى تاريخ') }}</td>
                                        <td>{{ __('دفعات') }}</td>
                                        <td>{{ __('أقساط') }}</td>
                                        <td>{{ __('الكل') }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $requests['main_project'] ? $array_returned['mainProject']->name :'الكل' }}</td>
                                        <td>{{ $requests['request_from'] ? $requests['request_from'] : 'من بداية المشروع' }}</td>
                                        <td>{{ $requests['request_to'] ? $requests['request_to'] : 'الى اليوم' }}</td>
                                        <td>{{ $array_returned['payments'] ? $array_returned['payments'] : '0' }}</td>
                                        <td>{{ $array_returned['installments'] ? $array_returned['installments'] : '0' }}</td>
                                        <td>{{ $array_returned ? $array_returned['payments'] + $array_returned['installments'] : '0' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--########  ###########-->
                    <!--########  ###########-->
