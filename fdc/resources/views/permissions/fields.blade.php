<!-- Name Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('name', __('messages.name'),['class'=>'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control','onkeyup' => 'auto_capitalize(this)']) !!}
    </div>
</div>


<!-- Key Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('key', __('messages.key'),['class'=>'control-label']) !!}
        {!! Form::text('key', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Cat Id Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('cat_id', __('messages.cat_id'),['class'=>'control-label']) !!}
        {!! Form::select('cat_id', $Permission, null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('permissions.index') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
</div>


@section('scripts')
    <script type="text/javascript">
       function auto_capitalize(s) {
           var str = s.value;
           var text = str.replace(/\s/g,'_').toLowerCase();
           $('#key').val(text);
       }
    </script>
@endsection

