<!-- Name Bn Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('name', 'Name',['class'=>'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: left;">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('itemDepartments.index') }}" class="btn btn-danger">Cancel</a>
</div>
