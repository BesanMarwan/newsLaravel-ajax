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
                <form method="post" id="userForm" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" id="id" class="id" name="id" value="">
                    <div class="">
                        <div class="row mb-3">

                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>اسم المستخدم(كامل ): <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm mb-3" id="name"
                                       data-parsley-class-handler="#lnWrapper" value="" name="name" required="" type="text">
                                <small class="name_error form-text text-danger"></small>

                            </div>
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>اسم البديل: <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm mb-3" id="username"
                                       data-parsley-class-handler="#lnWrapper" value="" name="username" required="" type="text">
                            </div>
                            <small class="username_error form-text text-danger"></small>

                        </div>
                        <div class="row mb-3">
                            <div class="parsley-input col-md-12 mg-t-20 mg-md-t-0 mt-0" id="lnWrapper">
                                <label>نبذة عن المستخدم :</label>
                                <textarea class="form-control form-control-sm mb-3" value="" id="bio" rows="5" data-parsley-class-handler="#lnWrapper"
                                          name="bio" ></textarea>
                            </div>
                            <small class="bio_error form-text text-danger"></small>

                        </div>
                        <div class="row mb-3">

                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>صورة البروفايل: </label>
                                <input type="file" class="form-control form-control-sm mb-3"
                                       data-parsley-class-handler="#lnWrapper" id="user-profile"  value="" name="user_image" >
                            </div>
                            <small class="user_image_error form-text text-danger"></small>


                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>البريد الالكتروني: <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm mb-3" id="email"
                                       data-parsley-class-handler="#lnWrapper" name="email" value="" required="" type="email">
                            </div>
                            <small class="email_error form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="row mb-3 "id="passDiv">
                        <div class="pass parsley-input col-md-6 mg-t-20 mg-md-t-0 mt-0" id="lnWrapper">
                            <label>كلمة المرور: <span class="text-danger">*</span></label>
                            <input class="form-control form-control-sm mb-3" data-parsley-class-handler="#lnWrapper"
                                   name="password"  id="password" value="" type="password">
                            <small class="password_error form-text text-danger"></small>

                        </div>

                        <div class="pass parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label> تاكيد كلمة المرور: <span class="text-danger">*</span></label>
                            <input class="form-control form-control-sm mb-3" data-parsley-class-handler="#lnWrapper"
                                   name="confirm-password" id="confirm" type="password">

                            <small class="confirm-password_error form-text text-danger"></small>

                        </div>
                    </div>

                    <div class="row row-sm  mb-3">
                        <div class="col-lg-6">
                            <label class="form-label">حالة المستخدم</label>
                            <select name="status" id="select-beast" class="form-control form-control-lg w-100 nice-select custom-select">
                                <option value="1" id="status1">مفعل</option>
                                <option value="0" id="status0">غير مفعل</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">صلاحية  المستخدم</label>
                            {!! Form::select('roles_name[]', $roles,[], array('class' => ['w-100','form-control','form-control-lg','nice-select','custom-select'],'id'=>'select-beast')) !!}

                        </div>
                    </div>
                    <br><br>


                    <div class="modal-footer">
                        <button type="button" name="reset" class=" btn btn-secondary"
                                data-dismiss="modal">الغاء</button>
                        <button type="submit" name="submit"  class="submit btn btn-success " id="">حفظ البيانات</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
