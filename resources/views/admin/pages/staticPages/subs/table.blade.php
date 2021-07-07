<table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
       style="text-align: center">
    <thead>
    <tr>
        <th>#</th>
        <th > اسم الصفحة</th>
        <th >محتوى الصفحة</th>
        <th>الاجراءات</th>
    </tr>
    </thead>
    <tbody id="table_data">
    @if(isset($staticPages))
        @foreach ($staticPages as $staticPage)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $staticPage->title }}</td>
                <td>{!!  $staticPage->content !!}</td>
                <td>
                    @can('تعديل الصفحات')
                        <a  href="" class="editPage btn btn-info btn-sm"
                            title="تعديل" data-id="{{$staticPage->id}}"><i class="fa fa-edit"></i></a>
                    @endcan
                    @can('حدف الصفحة')
                            <button type="button" class="delPage btn btn-danger btn-sm" data-toggle="modal"
                                                  data-id="{{$staticPage->id}}"
                                                  title="حدف الخبر"><i
                                class="fa fa-trash"></i></button>
                    @endcan
                </td>
            </tr>

        @endforeach
    @endif

    </tbody>

</table>


<div class="d-flex justify-content-center">
    {!! $staticPage->render() !!}
</div>
