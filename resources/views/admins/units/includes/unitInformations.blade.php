<div class="card-body">
    <div class="table-responsive">
        <table width="100%" style="margin-bottom: 10px">
            <thead>
                <tr>
                    <td >المشروع الرئيسي </td>
                    <td >القسم  </td>
                    <td >المبنى  </td>
                    <td >الدور</td>
                    <td >التميز</td>
                    <td >id</td>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td><a href="{{ url('show_main_project/'.$unit->main_project_id) }}">{{$unit->mainProject->name}}</a></td>
                    <td><a href="{{ route('subProperties.show', ['subProperty'=>$unit->sub_property_id]) }}">{{$unit->subProperty->name}}</a></td>
                    <td><a href="{{ url('showConstruction/'.$unit->construction_id) }}">{{$unit->construction->name}}</a></td>
                    <td><a href="{{ route('levels.show', ['id'=>$unit->level_id, 'constructionId'=>$unit->construction->id]) }}">{{$unit->level->name}}</a></td>
                    <td>{{$unit->site->name}}</td>
                    <td>{{$unit->id}}</td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    @if ($unit->customer_id > 0)
                    <td >تاريخ التعاقد </td>
                    @if (!empty($unit->finance->monthes_count) && !empty($unit->financePercentages->sum('payment_kind_value')) && !empty($unit->installments_count))
                    <td > {{__('دفعة اقساط')}} </td>
                    @endif
                    @endif
                    <td >نظام الدفع </td>
                    <td >اجمالي الوحدة</td>
                    <td >سعر المتر</td>
                    <td >المساحة</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @if ($unit->customer_id > 0)
                    <td>{{$unit->created_at->format('Y-m-d')}}</td>
                    @if (!empty($unit->finance->monthes_count) && !empty($unit->financePercentages->sum('payment_kind_value')) && !empty($unit->installments_count))
                    <td>{{$unit->finance->monthes_count * intval(($unit->unit_price - $unit->financePercentages->sum('payment_kind_value')) / $unit->installments_count)}}</td>
                    @endif
                    @endif
                    <td>{{ $unit->finance_id ? $unit->finance->name : 'لا يوجد نظام دفع' }}</td>
                    <td>{{$unit->unit_price}}</td>
                    <td>{{$unit->price_m}}</td>
                    <td>{{$unit->space}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    @if ($unit->overMuchUnits)
                    <td > {{ __('وقت زيادة الاسعار') }} </td>
                    <td > {{ __('تاريخ زيادة الاسعار') }} </td>
                    <td > {{ __('السعر الجديد للوحدة') }} </td>
                    <td > {{ __('السعر الجديد للمتر') }} </td>
                    <td > {{ __('نسبة الزيادة') }} </td>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($unit->overMuchUnits as $overMuchUnit)
                <tr>
                    <td>{{$overMuchUnit->created_at->format('h:i:s A')}}</td>
                    <td>{{$overMuchUnit->created_at->format('Y-m-d')}}</td>
                    <td>{{$overMuchUnit->new_unit_price}}</td>
                    <td>{{$overMuchUnit ->new_price_m}}</td>
                    <td>{{$overMuchUnit->over_much}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
