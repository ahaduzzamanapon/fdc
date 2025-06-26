<!-- From Date Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('from_date', 'From Date',['class'=>'control-label']) !!}
        {!! Form::text('from_date', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- To Date Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('to_date', 'To Date',['class'=>'control-label']) !!}
        {!! Form::text('to_date', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Total Day Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('total_day', 'Total Day',['class'=>'control-label']) !!}
        {!! Form::text('total_day', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Approved From Date Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('approved_from_date', 'Approved From Date',['class'=>'control-label']) !!}
        {!! Form::text('approved_from_date', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Approved To Date Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('approved_to_date', 'Approved To Date',['class'=>'control-label']) !!}
        {!! Form::text('approved_to_date', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Approved Total Day Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('approved_total_day', 'Approved Total Day',['class'=>'control-label']) !!}
        {!! Form::text('approved_total_day', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Remark Field -->
<div class="col-md-12">
    <div class="form-group ">
        {!! Form::label('remark', 'Remark',['class'=>'control-label']) !!}
        {!! Form::textarea('remark', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Status Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('status', 'Status',['class'=>'control-label']) !!}
        {!! Form::select('status', ['draft' => 'draft', 'on_processing' => 'on_processing', 'approved' => 'approved', 'reject' => 'reject'], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Approver Remark Field -->
<div class="col-md-12">
    <div class="form-group ">
        {!! Form::label('approver_remark', 'Approver Remark',['class'=>'control-label']) !!}
        {!! Form::textarea('approver_remark', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('leaves.index') }}" class="btn btn-danger">Cancel</a>
</div>
