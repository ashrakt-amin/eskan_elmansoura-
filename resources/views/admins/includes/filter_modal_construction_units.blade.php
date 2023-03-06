
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$construction->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <form action="{{ route('levels.search', ['construction_id'=>$construction->id]) }}" method="GET" enctype="multipart/form-data">
                            <div class="user-details">
                                @if ( count($construction->units->unique('sub_property_id')) > 1 )
                                <div class="input-box" style="width: 100%">
                                    <select  name="subProperty" id="" class="custom-select form-control font-weight-bold text-dark text-center">
                                        @php
                                            $unitHere=\App\Models\Unit::where('construction_id', $construction->id)->first()
                                        @endphp
                                        <option value="الكل">قسم الوحدات</option>
                                        @foreach ($construction->units->unique('sub_property_id') as $unitSub)
                                        <option value="{{ $unitSub->subProperty->id }}">{{ $unitSub->subProperty->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="input-box" style="width: 100%">
                                    <select  name="status" id="" class="custom-select form-control font-weight-bold text-dark text-center">
                                        <option value="الكل">حالة الوحدات</option>
                                        <option value="خالية">وحدات خالية</option>
                                        <option value="تعاقد">وحدات تعاقد</option>
                                        <option value="محجوزة">وحدات محجوزة</option>
                                        <option value="ملغاة">وحدات ملغاة</option>
                                    </select>
                                </div>
                                <div class="input-box" style="width: 100%">
                                    <select  name="level_id" id="" class="custom-select form-control font-weight-bold text-dark text-center">
                                        <option value="الكل">كل الادوار</option>
                                        @foreach (\App\Models\Level::orderBy('id', 'asc')->get() as $levelHere)
                                        @foreach ($construction->units->unique('level_id') as $unit)
                                        @if ($levelHere->id == $unit->level->id)
                                        <option value="{{ $unit->level->id }}">{{ $unit->level->name }}</option>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                <!------------------------------------- Submit ------------------------------------->
                                <div class="form-button">
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
