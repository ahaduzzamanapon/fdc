@php
        $categories = \App\Models\ItemCategory::all()->pluck('name_bn', key: 'id')->prepend(__('messages.select_category'), '')->toArray();
    $units = \App\Models\ItemUnit::all()->pluck('name_bn', key: 'id')->prepend(__('messages.select_unit'), '')->toArray();
@endphp
<!-- Name Bn Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('name_bn', __('messages.name_bn'),['class'=>'control-label']) !!}
        {!! Form::text('name_bn', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>


<!-- Name En Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('name_en', __('messages.name_en'),['class'=>'control-label']) !!}
        {!! Form::text('name_en', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>


<!-- Cat Id Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('cat_id', __('messages.category_label'),['class'=>'control-label']) !!}
        {!! Form::select('cat_id', $categories, null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>


<!-- Unit Id Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('unit_id', __('messages.unit_label'),['class'=>'control-label']) !!}
        {!! Form::select('unit_id', $units, null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>


<!-- Duration Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('duration', __('messages.duration'),['class'=>'control-label']) !!}
        {!! Form::select('duration', ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24'], null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>


<!-- Max Times Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('max_times', __('messages.max_times'),['class'=>'control-label']) !!}
        {!! Form::select('max_times', ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12'], null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>


<!-- Amount Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('amount', __('messages.amount'),['class'=>'control-label']) !!}
        {!! Form::text('amount', null, ['class' => 'form-control', 'required']) !!}
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
    <a href="{{ route('items.index') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
</div>
