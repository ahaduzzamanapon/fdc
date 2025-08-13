<!-- Name Bn Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('name_bn', __('messages.name_bn'),['class'=>'control-label']) !!}
        {!! Form::text('name_bn', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Name En Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('name_en', __('messages.name_en'),['class'=>'control-label']) !!}
        {!! Form::text('name_en', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Type Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('type', __('messages.type'),['class'=>'control-label']) !!}
        {!! Form::select('type', [__('messages.el') => __('messages.el'), __('messages.cl') => __('messages.cl'), __('messages.sl') => __('messages.sl'), __('messages.ml') => __('messages.ml'), __('messages.pl') => __('messages.pl')], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Day Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('day', __('messages.day'),['class'=>'control-label']) !!}
        {!! Form::number('day', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Status Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('status', __('messages.status'),['class'=>'control-label']) !!}
        {!! Form::select('status', [__('messages.active') => __('messages.active'), __('messages.inactive') => __('messages.inactive')], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('leaveTypes.index') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
</div>
