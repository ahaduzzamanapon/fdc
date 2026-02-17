
<tr>
    <th scopre="row">{!! Form::label('flow_id', 'Flow Name:') !!}</th>
    <td>{{ $approvalFlowSteps->flow_name }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('from_role_id', 'From Role:') !!}</th>
    <td>{{ $approvalFlowSteps->from_role_name }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('to_role_id', 'To Role:') !!}</th>
    <td>{{ $approvalFlowSteps->to_role_name }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('step_order', 'Step Order:') !!}</th>
    <td>{{ $approvalFlowSteps->step_order }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('created_at', 'Created At:') !!}</th>
    <td>{{ $approvalFlowSteps->created_at }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('updated_at', 'Updated At:') !!}</th>
    <td>{{ $approvalFlowSteps->updated_at }}</td>
</tr>


