<div class="table-responsive">
    <table class="table" id="approvalFlowSteps-table">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Flow Name</th>
                <th>From Role</th>
                <th>To Role</th>
                <th>Step Order</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($approvalFlowSteps as $key => $approvalFlowSteps)
            <tr>
                <td>{{ $key + 1 }}</td>
            <td>{{ $approvalFlowSteps->flow_name }}</td>
            <td>{{ $approvalFlowSteps->from_role_name }}</td>
            <td>{{ $approvalFlowSteps->to_role_name }}</td>
            <td>{{ $approvalFlowSteps->step_order }}</td>
            <td>{{ $approvalFlowSteps->created_at }}</td>
            <td>{{ $approvalFlowSteps->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['approvalFlowSteps.destroy', $approvalFlowSteps->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('approvalFlowSteps.show', [$approvalFlowSteps->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('approvalFlowSteps.edit', [$approvalFlowSteps->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
