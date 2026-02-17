<div class="table-responsive">
    <table class="table" id="approvalLogs-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>Request Id</th>
        <th>Action By</th>
        <th>Action Role Id</th>
        <th>Action</th>
        <th>Remarks</th>
        <th>Created At</th>
        <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($approvalLogs as $key => $approvalLogs)
            <tr>
                <td>{{ $approvalLogs->id }}</td>
            <td>{{ $approvalLogs->request_id }}</td>
            <td>{{ $approvalLogs->action_by }}</td>
            <td>{{ $approvalLogs->action_role_id }}</td>
            <td>{{ $approvalLogs->action }}</td>
            <td>{{ $approvalLogs->remarks }}</td>
            <td>{{ $approvalLogs->created_at }}</td>
            <td>{{ $approvalLogs->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['approvalLogs.destroy', $approvalLogs->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('approvalLogs.show', [$approvalLogs->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('approvalLogs.edit', [$approvalLogs->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
