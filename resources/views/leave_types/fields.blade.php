<!-- Name Bn Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('name_bn', 'Name Bn',['class'=>'control-label']) !!}
        {!! Form::text('name_bn', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Name En Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('name_en', 'Name En',['class'=>'control-label']) !!}
        {!! Form::text('name_en', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Type Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('type', 'Type',['class'=>'control-label']) !!}
        {!! Form::select('type', ['el' => 'el', 'cl' => 'cl', 'sl' => 'sl', 'ml' => 'ml', 'pl' => 'pl'], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Day Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('day', 'Day',['class'=>'control-label']) !!}
        {!! Form::number('day', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Status Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('status', 'Status',['class'=>'control-label']) !!}
        {!! Form::select('status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('leaveTypes.index') }}" class="btn btn-danger">Cancel</a>
</div>
