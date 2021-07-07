@extends('admin.layouts.admin')
@section('css')
    @toastr_css
@section('title','الاخبار')
    <!-- breadcrumb -->
@section('PageTitle')
    عرض الاخبار
@stop
@endsection
@section('content')
    <!-- row -->
    <div class="row">


        @if ($errors->any())
            <div class="error">{{ $errors->first('Name') }}</div>
        @endif


        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                        @can('اضافة خبر')
                        <button type="button" class="addPost button x-small" >
                            اضافة خبر
                        </button>
                        @endcan
                    <br><br>

                    <div class="table-responsive" id="posts">
                      @include('admin.pages.posts.subs.table')
                    </div>
                </div>
            </div>
        </div>
        @include('admin.pages.posts.subs.modal')
        @include('admin.pages.posts.subs.modal-delete')


</div>

    <!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render
    <script>
        $ (function() {
            fetchRecords();
            $('.summernote').summernote({
                height: 200,

            });
            $('body').on('click', '.pagination a', function (e) {
                e.preventDefault();
                $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 10000;" src="https://i.imgur.com/v3KWF05.gif />');
                var url = $(this).attr('href');
                window.history.pushState("", "", url);
                loadPosts(url);
            });

            function loadPosts(url) {
                $.ajax({
                    url: url
                }).done(function (data) {
                    $('#posts').html(data);
                }).fail(function () {
                    console.log("Failed to load data!");
                });
            }
        });

        function fetchRecords() {
            $.ajax({
                url: '{{route('admin.posts.index')}}' ,
                type: 'get',
                success: function (response) {
                    $('#posts').empty().html(response);
                }
            });
        }

        /********************** all event (clicking)****************/
        $(document).on('click','.addPost',function(e){
            e.preventDefault();
            $('#model_id').modal('show');
            $('.modal-title').text('اضافة الخبر');
            $('.submit').text('حفظ البيانات');
            $('.submit').attr('id','savePost');
            $('.img').detach();
            $('#title').val('');
            $('.summernote').summernote("code",'');
            $('#meta').val('');
            $('#alt').val('');
            $('#cat0').attr('selected','');
            $('#status1').attr('selected','');
            $('.title_error').text('');
            $(".content_error").text('');
            $(".category_error").text('');
            $(".image_error").text('');

        });
        $(document).on('click','.editPost',function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            $.get('posts/edit/' + id , function (data) {
                $('#model_id').modal('show');
                $('.modal-title').text('تعديل الخبر');
                $('.img').detach();
                $('.submit').text('تحديث البيانات');
                $('.title_error').text('');
                $(".content_error").text('');
                $(".category_error").text('');
                $(".image_error").text('');
                $('#id').attr('value',data[0].id);
                $('#title').val(data[0].title);
                $('.summernote').summernote("code",data[0].content);
                $('#meta').val(data[0].meta_data);
                $('#alt').val(data[0].media[0].alt);
                $('#cat'+data[0].category.id).attr('selected','');
                // $('#update').val(data[0].media[0].file_name);
                $('#status'+data[0].comment).attr('selected','');
                var img ='<img src="/'+data[0].media[0].file_name+'" alt="'+data[0].media[0].alt+'" height="150px" width="300px" class="img m-auto mb-2"> ';
                $('#postForm').prepend(img);
                $('.submit').attr('id','editPost');

            });
        });

        $(document).on('click','.delPost',function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            $('.modDelete').modal('show');
            $('#id').text(id);
            $('.delete_btn').attr('data-id',id);

        });

        $(document).on('click','#close',function(e){
            $('#postForm')[0].reset();
            $('#id').attr('value','');
            $('#title').val('');
            $('.summernote').summernote("code",'');
            $('#meta').val('');
            $('#alt').val('');
            $('#cat0').attr('selected','');
            $('#status1').attr('selected','');
            $('.img').detach();
            $('.title_error').text('');
            $(".content_error").text('');
            $(".category_error").text('');
            $(".image_error").text('');

        });

        $(document).on('click','#reset',function(e){
            $('#postForm')[0].reset();
            $('#id').attr('value','');
            $('#title').val('');
            $('.summernote').summernote("code",'');
            $('#meta').val('');
            $('#alt').val('');
            $('#cat0').attr('selected','');
            $('#status1').attr('selected','');
            $('.img').detach();
            $('.title_error').text('');
            $(".content_error").text('');
            $(".category_error").text('');
            $(".image_error").text('');
        });

        /********************** add category with ajax ****************************/
                    $(document).on('click', '#savePost', function (e) {
                        e.preventDefault();
                        let myForm = document.getElementById('postForm');
                        var formData = new FormData(myForm);
                        $.ajax({
                            type: 'POST',
                            enctype: 'multipart/form-data',
                            url: "{{route('admin.posts.store')}}",
                            data: formData,
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function (data) {
                                $('#model_id').modal('hide');
                                fetchRecords();
                                if(data.status==true)
                                    toastr.success(data.success);
                                else
                                    toastr.error(data.error);
                                $('#postForm')[0].reset();
                            }, error: function (reject) {
                                var response = $.parseJSON(reject.responseText);
                                $.each(response.errors, function (key, val) {
                                    $("." + key + "_error").text(val[0]);
                                });
                                // toastr.error(reject.error);


                            }
                        });
                    });


                    /********************** edit category with ajax ****************************/
                    $(document).on('click', '#editPost', function (e) {
                        e.preventDefault();
                        let myForm = document.getElementById('postForm');
                        var formData = new FormData(myForm);

                        $.ajax({
                            type: 'POST',
                            enctype: 'multipart/form-data',
                            url: "{{route('admin.posts.update')}}",
                            data: formData,
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function (data) {
                                $('#model_id').modal('hide');
                                fetchRecords();
                                if(data.status==true)
                                    toastr.success(data.success);
                                else
                                    toastr.error(data.error);
                                $('#postForm')[0].reset();
                            }, error: function (reject) {
                                var response = $.parseJSON(reject.responseText);
                                $.each(response.errors, function (key, val) {
                                    $("." + key + "_error").text(val[0]);
                                });
                            }
                        });
                    });


                    /*************************************** delete with ajax *****************************************/
                    $(document).on('click', '.delete_btn', function (e) {
                        e.preventDefault();
                        var id = $(this).attr('data-id');
                        $.ajax({
                            type: 'POST',
                            url: "{{route('admin.posts.delete')}}",
                            data: {
                                '_token': "{{csrf_token()}}",
                                'id'    : id
                            },
                            success: function (data) {
                                $('.modDelete').modal('hide');
                                fetchRecords();
                                if(data.status==true)
                                    toastr.success(data.success);
                                else
                                    toastr.error(data.error);
                                },
                            error: function (reject) {
                                toastr.error(reject.error)
                            }
                        });
                    });



    </script>

@endsection
