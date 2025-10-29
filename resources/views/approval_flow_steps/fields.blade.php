@php
    $flows = \App\Models\ApprovalFlowMaster::all()->pluck('name', key: 'id')->prepend(__('Select Flow'), '')->toArray();
    $roles = \App\Models\RoleAndPermission::all()->pluck('name', key: 'id')->prepend(__('Select User Role'), '')->toArray();
@endphp

<!-- Flow Id Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('flow_id', 'Flow:',['class'=>'control-label']) !!}
        {!! Form::select('flow_id', $flows, null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>


<!-- From Role Id Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('from_role_id', 'From User Role:',['class'=>'control-label']) !!}
        {!! Form::select('from_role_id', $roles, null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>


<!-- To Role Id Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('to_role_id', 'To User Role:',['class'=>'control-label']) !!}
        {!! Form::select('to_role_id', $roles, null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>


<!-- Step Order Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('step_order', 'Step Order (Sequence)',['class'=>'control-label']) !!}
        {!! Form::number('step_order', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('approvalFlowSteps.index') }}" class="btn btn-danger">Cancel</a>
</div>
