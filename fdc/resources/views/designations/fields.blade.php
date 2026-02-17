<!-- Desi Name Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('desi_name', __('messages.name'),['class'=>'control-label']) !!}
        {!! Form::text('desi_name', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Desi Status Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('desi_status', __('messages.status'),['class'=>'control-label']) !!}
        {!! Form::select('desi_status', [__('messages.active') => __('messages.active'), __('messages.inactive') => __('messages.inactive')], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('designations.index') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
</div>
