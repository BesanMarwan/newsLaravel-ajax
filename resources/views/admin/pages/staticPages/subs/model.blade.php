<div class="modal fade" id="model_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form method="post" id="pageForm" >
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label>عنوان الصفحة :<span class="text-danger">*</span></label>
                            <div class="controls">
                                <input type="text" name="title" id="title" class="form-control" value="" required="" data-validation-required-message="هذا الحقل محتوطلوب " aria-invalid="false" >
                                <div class="help-block"></div>
                            </div>
                            <small class="title_error form-text text-danger"></small>
                            <input type="hidden" id="id" name="id" value="">
                        </div>
                        <div class="col">
                            <label>رابط الصفحة :<span class="text-danger">*</span></label>
                            <div class="controls">
                                <input type="text" name="slug" id="slug" class="form-control" value="" required="" data-validation-required-message="هذا الحقل محتوطلوب " aria-invalid="false" >
                                <div class="help-block"></div>
                            </div>
                            <small class="slug_error form-text text-danger"></small>
                        </div>


                    </div>
                    <div class="form-group">
                        <label>  محتوى الصفحة : </label>
                        <textarea id="content" class="form-control summernote" name="content" rows="8"  aria-invalid="false"></textarea>
                        <div class="help-block"></div>
                        <small class="content_error form-text text-danger"></small>

                    </div>
                    <br><br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal" id="reset">الغاء</button>
                        <button type="submit" id="" class="submit btn btn-success" >حفظ البيانات</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
