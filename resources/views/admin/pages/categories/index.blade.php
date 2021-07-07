@extends('admin.layouts.admin')
@section('css')
    @toastr_css
@section('title')
    الاقسام
@stop
@endsection
@section('page-header','الاقسام الرئيسية')
    <!-- breadcrumb -->
@section('PageTitle','الاقسام الرئيسية')
@section('content')
    <!-- row -->
    <div class="row">


        @if ($errors->any())
            <div class="error">{{ $errors->first('Name') }}</div>
        @endif



        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                    @can('اضافة قسم')
                    <button type="button" class="button x-small addCat" data-toggle="modal" data-target="#exampleModal">
                        اضافة قسم
                    </button>
                        @endcan
                    <br><br>

                    <div class="table-responsive" id="categories">
                        @include('admin.pages.categories.sub.table')

                    </div>
                </div>
            </div>
            </div>
        </div>
             @include('admin.pages.categories.sub.model')
             @include('admin.pages.categories.sub.model-delete')


@endsection
@section('js')
    @toastr_js
    @toastr_render
    <script>
        $(function () {
            $('body').on('click', '.pagination a', function (e) {
                e.preventDefault();
                $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 10000;" src="https://i.imgur.com/v3KWF05.gif />');
                var url = $(this).attr('href');
                window.history.pushState("", "", url);
                loadCategories(url);
            });

            function loadCategories(url) {
                $.ajax({
                    url: url
                }).done(function (data) {
                    $('#categories').html(data);
                }).fail(function () {
                    console.log("Failed to load data!");
                });
            }
        });

        function fetchRecords() {
            $.ajax({
                url: '{{route('admin.categories.index')}}',
                type: 'get',
            }).done(function (data){
                $('#categories').empty().html(data);
            });
        }

    /********************** all event (clicking)****************/
        $(document).on('click','.addCat',function(e){
        e.preventDefault();
        $('#model_id').modal('show');
        $('.modal-title').text('اضافة القسم');
        $('.submit').text('حفظ البيانات');
        $('.submit').attr('id','saveCat');
        $("#name").val('');
        $("#description").text('');
        $('.description_error').text('');
        $(".name_error").text('');


        });

         $(document).on('click','.editCat',function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            $.get('categories/show/' + id , function (data) {
                $('#model_id').modal('show');
                $('.modal-title').text('تعديل القسم');
                $('.submit').text('تحديث البيانات');
                $('.description_error').text('');
                $(".name_error").text('');
                $('#id').attr('value',data.id);
                $('#name').val(data.name);
                $('#description').text(data.description);
                $('.submit').attr('id','editCat');

            });
        });

        $(document).on('click','.delCat',function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            $('.modDelete').modal('show');
            $('#id').text(id);
            $('.delete_btn').attr('cat_id',id);

        });

        $(document).on('click','#close',function(e){
            $('#categoryForm')[0].reset();
            $('#id').attr('value','');
            $('#name').val('');
            $('#description').text('');
            $(".title_error").text('');
            $('.slug_error').text('');
            $('.description_error').text('');
            $(".name_error").text('');
        });

        $(document).on('click','#reset',function(e){
            $('#categoryForm')[0].reset();
            $('#id').attr('value','');
            $('#name').val('');
            $('#description').text('');
            $('.description_error').text('');
            $(".name_error").text('');
        });


        /********************** add category with ajax ****************************/
        $(document).on('click', '#saveCat', function (e) {
            e.preventDefault();
            var formData = new FormData($('#categoryForm')[0]);
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "{{route('admin.categories.store')}}",
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
                    $('#categoryForm')[0].reset();
                }, error: function (reject) {
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function (key, val) {
                        $("." + key + "_error").text(val[0]);
                    });                }
            });
        });


    /********************** edit category with ajax ****************************/
        $(document).on('click', '#editCat', function (e) {
            e.preventDefault();
            var formData = new FormData($('#categoryForm')[0]);
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "{{route('admin.categories.update')}}",
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

                    $('#categoryForm')[0].reset();
                }, error: function (reject) {
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function (key, val) {
                        $("." + key + "_error").text(val[0]);
                    });                }
            });
        });


    /*************************************** delete with ajax *****************************************/
        $(document).on('click', '.delete_btn', function (e) {
            e.preventDefault();
            var id = $(this).attr('cat_id');
            $.ajax({
                type: 'POST',
                url: "{{route('admin.categories.delete')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': id
                },
                success: function (data) {
                        $('.modDelete').modal('hide');
                        fetchRecords();
                        // $('.category'+id).remove();
                    if(data.status==true) {
                        toastr.success(data.success);
                    }else{
                        toastr.error(data.error);
                    }
                },
                error: function (reject) {
                    toastr.error(reject.error);
                }
            });
        });


    </script>
@stop

