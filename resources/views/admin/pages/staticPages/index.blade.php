@extends('admin.layouts.admin')
@section('css')
    @toastr_css
@section('title')
    الصفحات الثابتة
@stop
@endsection
@section('page-header','الصفحات الثابتة')
    <!-- breadcrumb -->
@section('PageTitle','الصفحات الثابتة ')
@section('content')
    <!-- row -->
    <div class="row">


        @if ($errors->any())
            <div class="error">{{ $errors->first('Name') }}</div>
        @endif



        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                     @can('اضافة الصفحة')
                            <button type="button" class="addPage button x-small" data-toggle="modal" data-target="#exampleModal">
                                اضافة صفحة
                            </button>
                        @endcan
                        <br><br>

                    <div class="table-responsive" id="pages">
                        @include('admin.pages.staticPages.subs.table')
                    </div>
                </div>
            </div>
        </div>
        @include('admin.pages.staticPages.subs.model')
        @include('admin.pages.staticPages.subs.model-delete')

    </div>


    <!-- row closed -->
  <!-- row closed -->
  @endsection
@section('js')

        <script type="text/javascript">
            $(document).ready(function() {
                $('.summernote').summernote({
                height: 200,

            });

                $('body').on('click', '.pagination a', function (e) {
                    e.preventDefault();
                    $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 10000;" src="https://i.imgur.com/v3KWF05.gif />');
                    var url = $(this).attr('href');
                    window.history.pushState("", "", url);
                    loadPages(url);
                });

                function loadPages(url) {
                    $.ajax({
                        url: url
                    }).done(function (data) {
                        $('#pages').html(data);
                    }).fail(function () {
                        console.log("Failed to load data!");
                    });
                }
        });

            function fetchRecords() {
                $.ajax({
                    url: '{{route('admin.pages.index')}}' ,
                    type: 'get',
                    success: function (response) {
                        $('#pages').empty().html(response);
                    }
                });
            }

            /********************** all event (clicking)****************/
            $(document).on('click','.addPage',function(e){
                e.preventDefault();
                $('#model_id').modal('show');
                $('.modal-title').text('اضافة الصفحة');
                $('.submit').text('حفظ البيانات');
                $('.submit').attr('id','savePage');
                $(".title_error").text('');
                $('.slug_error').text('');
                $('.content_error').text('');
                $('#id').attr('value','');
                $('#title').val('');
                $('#slug').val('');
                $('.summernote').summernote("code",'');


            });

            $(document).on('click','.editPage',function(e){
                e.preventDefault();
                var id = $(this).attr('data-id');
                $.get('pages/edit/' + id , function (data) {
                    $('#model_id').modal('show');
                    // $('#id').attr('value',data.id);
                    $('#id').val(data.id);
                    $('#title').val(data.title);
                    $('#slug').val(data.slug);
                    $('.summernote').summernote("code",data.content);
                    $('.modal-title').text('تعديل الصفحة');
                    $('.submit').text('تحديث البيانات');
                    $(".title_error").text('');
                    $('.slug_error').text('');
                    $('.content_error').text('');
                    $('.submit').attr('id','editPage');

                });
            });

            $(document).on('click','.delPage',function(e){
                e.preventDefault();
                var id = $(this).attr('data-id');
                $('.modDelete').modal('show');
                $('#id').text(id);
                $('.delete_btn').attr('data-id',id);

            });

            $(document).on('click','#close',function(e){
                $('#pageForm')[0].reset();
                $('#id').attr('value','');
                $('#title').val('');
                $('.summernote').summernote("code",'');
                $(".title_error").text('');
                $('.slug_error').text('');
                $('.content_error').text('');
                $('#id').attr('value','');
                $('#title').val('');
                $('#slug').val('');
                $('.summernote').summernote("code",'');
            });

            $(document).on('click','#reset',function(e){
                $('#pageForm')[0].reset();
                $('#id').attr('value','');
                $('#title').val('');
                $('.summernote').summernote("code",'');
                $(".title_error").text('');
                $('.slug_error').text('');
                $('.content_error').text('');
                $('#id').attr('value','');
                $('#title').val('');
                $('#slug').val('');
                $('.summernote').summernote("code",'');
            });

            /********************** add static page with ajax ****************************/
            $(document).on('click', '#savePage', function (e) {
                e.preventDefault();
                var formData = new FormData($('#pageForm')[0]);
                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: "{{route('admin.pages.store')}}",
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
                        $('#pageForm')[0].reset();
                    }, error: function (reject) {
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("." + key + "_error").text(val[0]);
                        });
                    }
                });
            });

            /********************** edit page with ajax ****************************/
            $(document).on('click', '#editPage', function (e) {
                e.preventDefault();
                var formData = new FormData($('#pageForm')[0]);
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: "{{route('admin.pages.update')}}",
                    data:formData,
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
                        },
                    error: function (reject) {
                        toastr.error(reject.error);
                    }
                });
            });

            /********************************** delete with ajax *****************************************/
            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: "{{route('admin.pages.delete')}}",
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
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("." + key + "_error").text(val[0]);
                        });                          }
                });
            });



        </script>

        @toastr_js
    @toastr_render
@endsection
