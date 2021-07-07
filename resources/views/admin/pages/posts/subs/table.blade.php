<table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
       style="text-align: center">
    <thead>
    <tr>
        <th>#</th>
        <th>عنوان الخبر</th>
        <th>صورة الخبر </th>
        <th>القسم</th>
        <th>عدد المشاهدات</th>
        <th>الاجراءات</th>
    </tr>
    </thead>
    <tbody id="table_data">
    @if(isset($posts))
        @foreach ($posts as $post)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $post->title }}</td>
                <td>
                    @foreach($post->media as $media)
                        <img src="{{asset(''.$media->file_name)}}" height="150px" width="150px" alt="">
                    @endforeach
                </td>
                <td>{{ $post->category->name }}</td>
                <td>{{ $post->viewer_count }}</td>
                <td>
                    @can('تعديل الاخبار')
                        <a  href="" class="editPost btn btn-info btn-sm"
                            title="تعديل" data-id="{{$post->id}}"><i class="fa fa-edit"></i></a>
                    @endcan
                    @can('حدف خبر')
                        <button type="button" class="delPost btn btn-danger btn-sm" data-toggle="modal"
                                data-id="{{$post->id}}"
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
    {!! $posts->render() !!}
</div>
