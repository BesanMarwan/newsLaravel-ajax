<table id="datatable" class="table-to-refresh table  table-hover table-sm table-bordered p-0" data-page-length="50"
       style="text-align: center">
    <thead>
    <tr>
        <th>#</th>
        <th> اسم القسم</th>
        <th> الوصف </th>
        <th>الاجراءات</th>
    </tr>
    </thead>
    <tbody id="table_data">
    @if(isset($categories))
        @foreach ($categories as $category)
            <tr class="category{{$category->id}}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->getDescription() }}</td>
                <td>
                    @can('تعديل قسم')
                        <button type="button" class="editCat btn btn-info btn-sm" data-toggle="modal"
                                data-id="{{$category->id}}"
                                title="تعديل"><i class="fa fa-edit"></i></button>
                    @endcan
                    @can('حذف قسم')
                        <button type="button" class="delCat btn btn-danger btn-sm" data-toggle="modal"
                                data-id="{{$category->id}}"
                                title="حذف القسم"><i class="fa fa-trash"></i></button>
                    @endcan
                </td>
            </tr>

        @endforeach
    @endif

    </tbody>

</table>
<div class="d-flex justify-content-center">
{!! $categories->render() !!}
</div>


