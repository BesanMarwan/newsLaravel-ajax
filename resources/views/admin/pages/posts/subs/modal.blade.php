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
                <form method="post" class="m-t-30 " id="postForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id" value="">
                    <div class="form-group mt-3">
                        <label>عنوان الخبر :<span class="text-danger">*</span></label>
                        <div class="controls">
                            <input type="text" name="title" id="title" class="form-control" value="" required="" data-validation-required-message="هذا الحقل محتوطلوب " aria-invalid="false" >
                            <div class="help-block"></div>
                            <small class="title_error form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>  المحتوى : <span class="text-danger">*</span></label>
                        <div class="controls">
                            <textarea class="form-control summernote" id="content" name="content" rows="8" required="" aria-invalid="false"></textarea>
                            <div class="help-block"></div>
                            <small class="content_error form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">الكلمات الدلالية</label>
                        <input type="text" class="form-control" id="meta" aria-describedby="emailHelp" placeholder="" value="" name="meta_data">
                        <small id="name13" class="badge badge-default badge-danger form-text text-white  "> ضع علامة # قبل كل كلمة دلالية</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6>القسم <span class="text-danger">*</span></h6>
                                <div class="controls">
                                    <select name="category" class="form-control form-control-lg w-100" id="exampleFormControlSelect1" required="" aria-invalid="false">
                                        <option id="cat0" value="0"  disabled selected> اختيار القسم</option>
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" id="cat{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="category_error form-text text-danger"></small>
                                    <div class="help-block"></div>
                                </div></div></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6>التعليق ع البوست :</h6>
                                <select name="comment_able" class="form-control form-control-lg w-100" id="exampleFormControlSelect" required="" aria-invalid="false">
                                    <option value="1" id="status1" selected>مفعل</option>
                                    <option value="0" id="status0">غير مفعل</option>
                                </select>

                            </div></div></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6>صورة الخبر</h6>
                                <input name="image"  type="file"   class="form-control">
                                <small class="image_error form-text text-danger"></small>


                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6> وصف للصورة  :</h6>
                                <div class="controls">
                                    <input type="text" name="alt" id="alt" class="form-control form-control-lg" value="" required="" data-validation-required-message="هذا الحقل مطلوب " aria-invalid="false" >
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <button type="reset" id="reset" class="reset btn btn-secondary"
                            data-dismiss="modal">الغاء</button>
                    <button type="submit"  class="submit btn btn-success " id="">حفظ البيانات</button>
                </form>

            </div>
        </div>
    </div>

</div>
