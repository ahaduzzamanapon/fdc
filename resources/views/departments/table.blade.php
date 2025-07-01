<div class="table-responsive">
    <table class="table" id="departments-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>Name Bn</th>
        <th>Name En</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($departments as $key => $department)
            <tr>
                <td>{{ $department->id }}</td>
            <td>{{ $department->name_bn }}</td>
            <td>{{ $department->name_en }}</td>
            <td>{{ $department->status }}</td>
            <td>{{ $department->created_at }}</td>
            <td>{{ $department->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['departments.destroy', $department->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('departments.show', [$department->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('departments.edit', [$department->id]) }}" class='btn btn-outline-primary btn-xs'><i
                                class="im im-icon-Pen"  data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="Delete"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
