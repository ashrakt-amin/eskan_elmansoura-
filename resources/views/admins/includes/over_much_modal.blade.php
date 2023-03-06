<!-- bootstrap -->
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-body">
                <div class="form-container">
                    <div class="title">{{ __('نسبة الزيادة') }}</div>
                    <form action="{{ route('overMuchUnits.store') }}" method="POST">
                        @csrf
                        <div class="user-details">
                            <!------------------------------------- OVER MUCH ------------------------------------->
                            <div class="input-box" style="width: 100%">
                                <span class="details"></span>
                                <input type="text" name="{{__('over_much')}}" placeholder="{{ __('اضافة رقم فقط') }}" value="" required>
                            </div>
                            <!--################################### OVER MUCH ###################################-->
                            <!-------------------------------------  MAIN PROJECT ------------------------------------->
                            <div class="input-box" style="width: 100%">
                                <span class="details"></span>
                                <input type="text" name="{{__('main_project_id')}}" value="{{ $mainProject->name }}" disabled>
                                <input type="hidden" name="{{__('main_project_id')}}" value="{{ $mainProject->id }}" required>
                            </div>
                            <!--################################### MAIN PROJECT ###################################-->
                        </div>
                        <div class="form-button">
                            <input type="submit" value="تعديل">
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
