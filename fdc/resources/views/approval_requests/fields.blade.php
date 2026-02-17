<!-- Flow Id Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('flow_id', 'Flow Id:',['class'=>'control-label']) !!}
        {!! Form::select('flow_id', ['' => ''], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Request Type Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('request_type', 'Request Type:',['class'=>'control-label']) !!}
        {!! Form::text('request_type', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Current Role Id Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('current_role_id', 'Current Role Id:',['class'=>'control-label']) !!}
        {!! Form::select('current_role_id', ['' => ''], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Next Role Id Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('next_role_id', 'Next Role Id:',['class'=>'control-label']) !!}
        {!! Form::select('next_role_id', ['' => ''], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Status Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('status', 'Status:',['class'=>'control-label']) !!}
        {!! Form::select('status', ['draft' => 'draft', 'on process' => 'on process', 'approved' => 'approved', 'rejected' => 'rejected'], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Request Data Field -->
<div class="col-md-12">
    <div class="form-group ">
        {!! Form::label('request_data', 'Request Data:',['class'=>'control-label']) !!}
        {!! Form::textarea('request_data', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Created By Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('created_by', 'Created By:',['class'=>'control-label']) !!}
        {!! Form::number('created_by', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('approvalRequests.index') }}" class="btn btn-danger">Cancel</a>
</div>
