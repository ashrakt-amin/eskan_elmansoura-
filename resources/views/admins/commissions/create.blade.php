
<!-- Modal -->
<div class="modal fade" id="commissionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">فلتر البحث</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="form-container">
                        <form action="{{ route('commissions.store') }}" method="POST">
                            @csrf
                            <div class="user-details">
                                <div class="input-box" style="width: 100%">
                                    <span class="details">{{ __('العميل') }}</span>
                                    <div class="select-box">
                                        <select data-show-subtext="true" data-live-search="true" class="selectpicker btn btn-primary w-100" name="customer_id" id="search-select">
                                                <option selected value="0" class="">عميل</option>
                                                @foreach ( \App\Models\Customer::all() as $customer)
                                                <option data-subtext="{{ $customer->national_id }}" value="{{ $customer->id }}" >{{ $customer->name.' '.$customer->mid_name.' '.$customer->last_name  }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="input-box" style="width: 100%">
                                    <span class="details">{{ __('النسبة') }}</span>
                                    <input type="text" name="percentage" id="" value="" placeholder="{{ __('ادخل رقم فقط') }}">
                                </div>
                                <div class="input-box" style="width: 100%">
                                    <span class="details">{{ __('الوحدة') }}</span>
                                    @if (isset($unit))
                                    <input type="text" name="" id="" value="{{ $unit->name }}" disabled>
                                    <input type="hidden" name="unit_id" id="" value="{{ $unit->id }}">
                                    @else
                                <div class="input-box" style="width: 100%">
                                    <span class="details">{{ __('الوحدة') }}</span>
                                    <div class="select-box">
                                        <select data-show-subtext="true" data-live-search="true" class="selectpicker btn btn-primary w-100" name="customer_id" id="search-select">
                                                <option selected value="0" class="">{{ __('الوحدة') }}</option>
                                                @foreach ( \App\Models\Unit::all() as $unit)
                                                <option data-subtext="{{ $unit->mainProject->name }}" value="{{ $unit->id }}" >{{ 'وحدة'.$unit->name.' '.$unit->construction->name.' '.$unit->level->name  }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                    @endif
                                </div>
                            </div>
                                <!------------------------------------- Submit ------------------------------------->
                                <div class="form-button text-center">
                                    <input type="submit" value="بحث">
                                </div>
                                <!--################################### Submit ###################################-->
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
            </div>
        </div>
    </div>
</div>
