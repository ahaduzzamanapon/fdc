@extends('layouts.default')

@section('title')
Photo Details @parent
@stop

@section('content')
<section class="content-header"></section>
<div class="content">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $photo->film_name }}</h5>
            <p><strong>ধরন:</strong> {{ $photo->type }}</p>
            <p><strong>মুক্তির তারিখ:</strong> {{ function_exists('convertToBengaliDate') ? convertToBengaliDate($photo->release_date) : $photo->release_date }}</p>
            @if($photo->image)
                <img src="{{ asset('storage/'.$photo->image) }}" alt="" style="max-width:400px;height:auto;border:1px solid #ddd;">
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('decadeFilmsPhotos.edit', $photo->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('decadeFilmsPhotos.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
