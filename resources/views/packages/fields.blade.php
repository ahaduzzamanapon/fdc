<!-- Name Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('name', __('messages.name'),['class'=>'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Amount Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('amount', __('messages.amount'),['class'=>'control-label']) !!}
        {!! Form::number('amount', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Type Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('type', __('messages.type'),['class'=>'control-label']) !!}
        {!! Form::select('type', [__('messages.cinema') => __('messages.cinema'), __('messages.drama') => __('messages.drama'), __('messages.others') => __('messages.others')], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Status Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('status', __('messages.status'),['class'=>'control-label']) !!}
        {!! Form::select('status', [__('messages.active') => __('messages.active'), __('messages.inactive') => __('messages.inactive')], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Description Field -->
<div class="col-md-12">
    <div class="form-group ">
        {!! Form::label('description', __('messages.description'),['class'=>'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('packages.index') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
</div>
