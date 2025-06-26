<tr>
    <th scopre="row">{!! Form::label('id', 'Id:') !!}</th>
    <td>{{ $leave->id }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('employee_id', 'Employee Id:') !!}</th>
    <td>{{ $leave->employee_id }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('from_date', 'From Date:') !!}</th>
    <td>{{ $leave->from_date }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('to_date', 'To Date:') !!}</th>
    <td>{{ $leave->to_date }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('total_day', 'Total Day:') !!}</th>
    <td>{{ $leave->total_day }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('approved_from_date', 'Approved From Date:') !!}</th>
    <td>{{ $leave->approved_from_date }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('approved_to_date', 'Approved To Date:') !!}</th>
    <td>{{ $leave->approved_to_date }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('approved_total_day', 'Approved Total Day:') !!}</th>
    <td>{{ $leave->approved_total_day }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('remark', 'Remark:') !!}</th>
    <td>{{ $leave->remark }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('status', 'Status:') !!}</th>
    <td>{{ $leave->status }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('approver_id', 'Approver Id:') !!}</th>
    <td>{{ $leave->approver_id }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('approver_remark', 'Approver Remark:') !!}</th>
    <td>{{ $leave->approver_remark }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('created_at', 'Created At:') !!}</th>
    <td>{{ $leave->created_at }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('updated_at', 'Updated At:') !!}</th>
    <td>{{ $leave->updated_at }}</td>
</tr>


