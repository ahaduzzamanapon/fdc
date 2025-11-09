<div class="table-responsive">
    <table class="table" id="approvalRequests-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>Flow Id</th>
        <th>Request Type</th>
        <th>Current Role Id</th>
        <th>Next Role Id</th>
        <th>Status</th>
        <th>Request Data</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($approvalRequests as $key => $approvalRequests)
            <tr>
                <td>{{ $approvalRequests->id }}</td>
            <td>{{ $approvalRequests->flow_id }}</td>
            <td>{{ $approvalRequests->request_type }}</td>
            <td>{{ $approvalRequests->current_role_id }}</td>
            <td>{{ $approvalRequests->next_role_id }}</td>
            <td>{{ $approvalRequests->status }}</td>
            <td>{{ $approvalRequests->request_data }}</td>
            <td>{{ $approvalRequests->created_by }}</td>
            <td>{{ $approvalRequests->created_at }}</td>
            <td>{{ $approvalRequests->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['approvalRequests.destroy', $approvalRequests->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('approvalRequests.show', [$approvalRequests->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('approvalRequests.edit', [$approvalRequests->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
