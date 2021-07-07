@extends('admin.layouts.admin')
@section('css')
    @toastr_css
@section('title')
    المستخدمين
@stop
@endsection
@section('content')
    <!-- row -->
    <div class="row">

        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    @can('اضافة مستخدم')
                        <button type="button" class="addUser button x-small" >
                            اضافة مستخدم
                        </button>
                    @endcan
                    <br><br>

                    <div class="table-responsive" id="users">
                        @include('admin.pages.users.subs.table')

                    </div>
                </div>
            </div>
        </div>
        @include('admin.pages.users.subs.modal')
        @include('admin.pages.users.subs.modal-delete')


    </div>

    <!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render
    <script>
        $ (function() {
            $('body').on('click', '.pagination a', function (e) {
                e.preventDefault();
                $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 10000;" src="https://i.imgur.com/v3KWF05.gif />');
                var url = $(this).attr('href');
                window.history.pushState("", "", url);
                loadUsers(url);
            });

            function loadUsers(url) {
                $.ajax({
                    url: url
                }).done(function (data) {
                    $('#users').html(data);
                }).fail(function () {
                    console.log("Failed to load data!");
                });
            }
        });


        function fetchRecords(){
            $.ajax({
                url: '{{route('admin.users.index')}}' ,
                type: 'get',
                success: function (response) {
                    $('#users').empty().html(response);
                }
            });
        }

        /********************** all event (clicking)****************/
        $(document).on('click','.addUser',function(e){
            e.preventDefault();
            $('#model_id').modal('show');
            $('.modal-title').text('اضافة مستخدم');
            $('.submit').text('حفظ البيانات');
            $('.submit').attr('id','saveUser');
            $('#id').attr('value','');
            $('#name').val('');
            $('#email').val('');
            $('#username').val('');
            $('#bio').text('');
            $('#user-profile').val('');
            $('#status1').attr('selected','');
            $('.name_error').text('');
            $(".username_error").text('');
            $(".email_error").text('');
            $(".password_error").text('');
            $(".user_image_error").text('');

        });
        $(document).on('click','.editUser',function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            $.get('users/get/' + id, function (data) {
                $('#model_id').modal('show');
                $('.modal-title').text('تعديل البيانات');
                $('.submit').text('تحديث البيانات');
                $('.submit').attr('id','editUser');
                $('.name_error').text('');
                $(".username_error").text('');
                $(".email_error").text('');
                $(".password_error").text('');
                $(".user_image_error").text('');
                $('#id').attr('value', data.id);
                $('#name').val(data.name);
                $('#email').val(data.name);
                $('#username').val(data.username);
                $('#bio').text(data.bio);
                $('#user-profile').val(data.user_image);
                $('#user-profile').attr('disabled', '');
                $('#status' + data.status).attr('selected', '');

            });
        });


        $(document).on('click', '.delUser', function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                $('.modDelete').modal('show');
                $('#id').text(id);
                $('.delete_btn').attr('data_id', id);

            });

        $(document).on('click', '#close', function (e) {
                $('#userForm')[0].reset();
                $('#id').attr('value','');
                $('#name').val('');
                $('#email').val('');
                $('#username').val('');
                $('#bio').text('');
                $('#user-profile').val('');
                $('#status1').attr('selected','');
                $('.name_error').text('');
                $(".username_error").text('');
                $(".email_error").text('');
                $(".password_error").text('');
                $(".user_image_error").text('');

            });

        $(document).on('click', '.profile', function (e) {
                var id = $(this).attr('id');
                console.log(id);
                window.location.href = "users/show/" + id;
            });

            /********************** add category with ajax ****************************/
            $(document).on('click', '#saveUser', function (e) {
                e.preventDefault();
                var formData = new FormData($('#userForm')[0]);
                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: "{{route('admin.users.store')}}",
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
                        $('#userForm')[0].reset();
                    }, error: function (reject) {
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("." + key + "_error").text(val[0]);
                        });
                    }
                });
            });


            /********************** edit category with ajax ****************************/
            $(document).on('click', '#editUser', function (e) {
                e.preventDefault();
                var formData = new FormData($('#userForm')[0]);
                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: "{{route('admin.users.update')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $('#model_id').modal('hide');
                        fetchRecords();
                        toastr.success(data.success);
                        $('#userForm')[0].reset();
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
                var id = $(this).attr('data_id');
                $.ajax({
                    type: 'POST',
                    url: "{{route('admin.users.delete')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'id': id
                    },
                    success: function (data) {
                        $('.modDelete').modal('hide');
                        fetchRecords();
                        toastr.success(data.success);
                    },
                    error: function (reject) {
                        toastr.error(reject.error);
                    }
                });
            });

    </script>
    <script>
        <!-- Internal Nice-select js-->
        <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

    <!--Internal  Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('js/form-validation.js')}}"></script>
    </script>
@endsection
