<!-- Film Name Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('film_name', __('messages.film_name') ?? 'Film Name',['class'=>'control-label']) !!}
        {!! Form::text('film_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Producer Name Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('producer_name', __('messages.producer_name') ?? 'Producer Name',['class'=>'control-label']) !!}
        {!! Form::text('producer_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Director Name Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('director_name', __('messages.director_name') ?? 'Director Name',['class'=>'control-label']) !!}
        {!! Form::text('director_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Acting Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('acting', __('messages.acting') ?? 'Acting',['class'=>'control-label']) !!}
        {!! Form::text('acting', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Type Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('type', __('messages.type') ?? 'Type',['class'=>'control-label']) !!}
        {!! Form::text('type', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Release Date Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('release_date', __('messages.release_date') ?? 'Release Date',['class'=>'control-label']) !!}
        {!! Form::date('release_date', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Achievements Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('achivements', __('messages.achievements') ?? 'Achievements',['class'=>'control-label']) !!}
        {!! Form::textarea('achivements', null, ['class' => 'form-control','rows'=>2]) !!}
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('decadeFilms.index') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
</div>
