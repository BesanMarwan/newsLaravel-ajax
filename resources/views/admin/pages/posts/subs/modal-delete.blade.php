{{--                                <!-- delete_modal_Post -->--}}
<div class="modal modDelete fade" id="" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Tajawal', sans-serif;" class="modal-title"
                    id="exampleModalLabel">
                    حدف الخبر
                </h5>
                <button type="button"  class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" >
                    @csrf
                    هل انت متاكد من حدف الخبر ؟!
                    <input id="id" type="hidden" name="id" class="form-control" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">الغاء</button>

                        <button
                            class="delete_btn btn btn-danger " type="submit" data-id="" >حدف الخبر</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

