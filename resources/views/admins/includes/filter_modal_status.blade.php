
<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <form action="{{ route('form_filters.statusFilter') }}" method="GET" enctype="multipart/form-data">
                            <div class="user-details">
                                <div class="input-box" style="width: 48%">
                                    <span class="details">من شهر</span>
                                    <input type="date" name="from" id="">
                                </div>
                                <div class="input-box" style="width: 48%">
                                    <span class="details">من سنة</span>
                                    <input type="date" name="to" id="">
                                </div>
                                <div class="input-box" style="width: 48%">
                                    <span class="details">{{ __('المشروع الرئيسي') }}</span>
                                    <select class="custom-select form-control font-weight-bold text-dark text-center" name="main_project" id="">
                                        <option class="text-center" value="">{{ __('المشروع') }}</option>
                                        @forelse ($index['mainProjects'] as $mainProject)
                                        <option class="text-center" value="{{ $mainProject->id }}">{{ $mainProject->name }}</option>
                                        @empty
                                        <option class="text-center" value=""></option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="input-box" style="width: 48%">
                                    <span class="details">{{ __('الحالة') }}</span>
                                    <select class="custom-select form-control font-weight-bold text-dark text-center" name="status" id="">
                                        <option class="text-center" value="">{{ __('الحالة') }}</option>
                                        <option class="text-center" value="{{ __('خالية') }}">{{ __('خالية') }}</option>
                                        <option class="text-center" value="{{ __('تعاقد') }}">{{ __('تعاقد') }}</option>
                                        <option class="text-center" value="{{ __('محجوزة') }}">{{ __('محجوزة') }}</option>
                                        <option class="text-center" value="{{ __('ملغاة') }}">{{ __('ملغاة') }}</option>
                                    </select>
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
