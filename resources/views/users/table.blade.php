




<div class="table-responsive">
    <table class="table table_data" id="users-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Group</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $key => $users)
            <tr>
                <td>{{ $key+1 }}</td>
            <td>{{ $users->name_bn }}</td>
            <td>{{ $users->role }}</td>
            <td>{{ $users->email }}</td>
            <td>
                @if($users->current_status == 'Active')
                    <span class="badge badge-success">সক্রিয়</span>
                @else
                    <span class="badge badge-danger">নিষ্ক্রিয়</span>
                @endif
            </td>
                <td>
                    <div class='btn-group'>
                        <a href="{{ route('users.show', [$users->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('users.edit', [$users->id]) }}" class='btn btn-outline-primary btn-xs'><i
                            class="im im-icon-Pen"  data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        @if(can('user_delete'))
                            {!! Form::open(['route' => ['users.destroy', $users->id], 'method' => 'delete']) !!}
                            {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="Delete"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
