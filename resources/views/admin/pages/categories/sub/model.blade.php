<!-- add_modal_Category -->
<div class="modal  fade" id="model_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Tajawal', sans-serif;" class="modal-title" id="exampleModalLabel">
                </h5>
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form method="post" id="categoryForm" >
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">اسم القسم
                                :</label>
                            <input id="name" type="text" name="name" class="form-control">
                            <small class="name_error form-text text-danger"></small>
                            <input type="hidden" id="id" name="id"  value="">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">الوصف
                            :</label>
                        <textarea class="form-control" name="description" id="description"
                                  rows="3"></textarea>
                        <small class="description_error form-text text-danger"></small>

                    </div>
                    <br><br>

                    <div class="modal-footer">
                        <button type="button" id="reset" class="btn btn-secondary"
                                data-dismiss="modal">الغاء</button>
                        <button type="submit"  class="submit btn btn-success " id="">حفظ البيانات</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
