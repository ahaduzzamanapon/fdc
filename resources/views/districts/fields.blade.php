@php
    $districtList = App\Models\Division::pluck('name_bn', 'id')->toArray();
@endphp

<!-- Name Bn Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('division_id', __('messages.division'),['class'=>'control-label']) !!}
        {!! Form::select('division_id', $districtList, null, ['class' => 'form-control']) !!}
    </div>
</div>

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


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('districts.index') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
</div>
