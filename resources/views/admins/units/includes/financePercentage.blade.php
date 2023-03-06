
<!-- Add Due Dates Modal -->
<div class="modal fade" id="addFinanceModal{{$unit->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اضافة مواعيد الاستحقاق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">





                    <div class="form-body">
                        <div class="form-container">
                            <form action="{{ route('addFinanceIdOrInstallments', ['id'=>$unit->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="user-details">

                                    <div class="input-box" style="width: 100%">
                                        <span class="details">الدفعة</span>
                                        <div class="select-box">
                                            <select name="finance_id" class="form-control @error('finance_id') is-invalid @enderror" value="{{ old('finance_id') }}" required>
                                                @foreach (\App\Models\Finance::orderby('id', 'asc')->get() as $finance)

                                                <option value="{{ $finance->id }}">{{ $finance->name }}</option>

                                                @endforeach
                                            </select>

                                            @error('finance_id')
                                            <span class="invalid-feedback" role="alert">
                                                <stron>{{ $message }}</stron>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="input-box" >
                                        <input type="hidden" value="{{ $unit->name }}" class="" name="unit_id" required>
                                        <input type="hidden" value="{{ $unit->unit_price }}" class="" name="unit_price" required>
                                    </div>
                                </div>


                                <!------------------------------------- Submit ------------------------------------->
                                <div class="form-button">
                                    <input type="submit" value="اضافة">
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
