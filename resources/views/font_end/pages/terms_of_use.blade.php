@extends('welcome')
@section('title', 'ব্যবহারের শর্তাবলি')

@section('body')
<div class="container py-4">
    <div class="section-title text-center p-3 mt-3">
        <h2 style="font-family: 'SolaimanLipi', sans-serif">ব্যবহারের শর্তাবলি</h2>
        <div class="title-shape mx-auto"></div>
    </div>

    <div class="mb-5 mt-2">
        @if($data->count() > 0)
            @foreach($data as $item)
                <div class="card mb-3">
                    <div class="card-body text-start">
                        @if($item->title)
                            <h4 class="card-title">{{ $item->title }}</h4>
                            <hr>
                        @endif
                        <div class="card-text pb-4">
                            {!! $item->description !!}
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info text-center">
                <p>No content available at the moment.</p>
            </div>
        @endif
    </div>
</div>
@stop