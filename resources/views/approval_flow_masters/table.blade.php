<div class="table-responsive">
    <table class="table" id="approvalFlowMasters-table">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Name</th>
                <th>Status</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($approvalFlowMasters as $key => $approvalFlowMaster)
            <tr>
                <td>{{ $key + 1 }}</td>
            <td>{{ $approvalFlowMaster->name }}</td>
            <td>{{ $approvalFlowMaster->status }}</td>
            <td>{{ $approvalFlowMaster->description }}</td>
            <td>{{ $approvalFlowMaster->created_at }}</td>
            <td>{{ $approvalFlowMaster->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['approvalFlowMasters.destroy', $approvalFlowMaster->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('approvalFlowMasters.show', [$approvalFlowMaster->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('approvalFlowMasters.edit', [$approvalFlowMaster->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
