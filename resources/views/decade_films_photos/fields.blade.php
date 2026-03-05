<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('film_name', 'চলচ্চিত্রের নাম', ['class'=>'control-label']) !!}
        {!! Form::text('film_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('type', 'ধরন', ['class'=>'control-label']) !!}
        {!! Form::text('type', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('release_date', 'মুক্তির তারিখ', ['class'=>'control-label']) !!}
        {!! Form::date('release_date', isset($photo) ? optional($photo->release_date)->format('Y-m-d') : null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('image', 'ছবি', ['class'=>'control-label']) !!}
        {!! Form::file('image', ['class' => 'form-control', 'accept' => 'image/*']) !!}
        @isset($photo->image)
            <small class="d-block mt-1">বর্তমান: <img src="{{ asset('storage/'.$photo->image) }}" alt="" style="width:80px;height:60px;object-fit:cover;"></small>
        @endisset
    </div>
</div>

<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('decadeFilmsPhotos.index') }}" class="btn btn-danger">Cancel</a>
</div>
