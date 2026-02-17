<!-- Request Id Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('request_id', 'Request Id:',['class'=>'control-label']) !!}
        {!! Form::number('request_id', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Action By Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('action_by', 'Action By:',['class'=>'control-label']) !!}
        {!! Form::number('action_by', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Action Role Id Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('action_role_id', 'Action Role Id:',['class'=>'control-label']) !!}
        {!! Form::text('action_role_id', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Action Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('action', 'Action:',['class'=>'control-label']) !!}
        {!! Form::text('action', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Remarks Field -->
<div class="col-md-12">
    <div class="form-group ">
        {!! Form::label('remarks', 'Remarks:',['class'=>'control-label']) !!}
        {!! Form::textarea('remarks', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('approvalLogs.index') }}" class="btn btn-danger">Cancel</a>
</div>
