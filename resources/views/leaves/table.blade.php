<div class="table-responsive">
    <table class="table" id="leaves-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>From Date</th>
        <th>To Date</th>
        <th>Total Day</th>
        <th>Approved From Date</th>
        <th>Approved To Date</th>
        <th>Approved Total Day</th>
        <th>Remark</th>
        <th>Status</th>
        <th>Approver Remark</th>
        <th>Created At</th>
        <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($leaves as $key => $leave)
            <tr>
                <td>{{ $leave->id }}</td>
            <td>{{ $leave->from_date }}</td>
            <td>{{ $leave->to_date }}</td>
            <td>{{ $leave->total_day }}</td>
            <td>{{ $leave->approved_from_date }}</td>
            <td>{{ $leave->approved_to_date }}</td>
            <td>{{ $leave->approved_total_day }}</td>
            <td>{{ $leave->remark }}</td>
            <td>{{ $leave->status }}</td>
            <td>{{ $leave->approver_remark }}</td>
            <td>{{ $leave->created_at }}</td>
            <td>{{ $leave->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['leaves.destroy', $leave->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('leaves.show', [$leave->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('leaves.edit', [$leave->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
