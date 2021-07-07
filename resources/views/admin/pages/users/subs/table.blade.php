<table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
       style="text-align: center">
    <thead>
    <tr>
        <th>صورة المستخدم</th>
        <th>الاسم </th>
        <th>البريد الالكتروني </th>
        <th>الحالة</th>
        <th class="text-center" style="width: 100px;">العمليات</th>
    </tr>
    </thead>
    <tbody id="table_data">
    @forelse($users as $user)
        <tr>
            <td>
                @if ($user->user_image != '')
                    <img src="{{ asset($user->user_image) }}" width="60">
                @else
                    <img src="{{ asset('images/users/default.png') }}" width="60">
                @endif
            </td>
            <td>
                <a href="{{route('admin.users.show',$user->id)}}">{{ $user->name }}</a>
                <p class="text-gray-400"><b>{{ $user->username }}</b></p>
            </td>
            <td>
                {{ $user->email }}
            </td>
            <td>{{ $user->status() }}</td>
            <td>
                <a  href="" class="editUser btn btn-info btn-sm"
                    title="تعديل صلاحية المستخدم" data-id="{{$user->id}}"><i class="fa fa-edit"></i></a>
                <button type="button" class="delUser btn btn-danger btn-sm" data-toggle="modal"
                        data-id="{{$user->id}}"
                        title="حدف المستخدم"><i
                        class="fa fa-trash"></i></button>

            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">No users found</td>
        </tr>
    @endforelse
    </tbody>

</table>
