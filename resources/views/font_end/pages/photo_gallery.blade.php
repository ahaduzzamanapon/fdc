@extends('welcome')
@section('title', 'ফটোগ্যালারী')

@section('body')
<style>
    .gallery-page-content .section-title {
        text-align: left !important;
        margin-bottom: 30px;
    }

    .gallery-page-content .title-shape {
        margin-left: 0 !important;
        margin-right: auto !important;
        width: 60px;
        height: 3px;
        background-color: #0d6efd;
        margin-top: 10px;
    }

    /* Flip Card CSS */
    .flip-card {
        background-color: transparent;
        width: 100%;
        height: 300px;
        /* Fixed height for consistent cards */
        perspective: 1000px;
        margin-bottom: 25px;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.6s cubic-bezier(0.4, 0.2, 0.2, 1);
        transform-style: preserve-3d;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .flip-card-front,
    .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        /* Safari */
        backface-visibility: hidden;
        border-radius: 10px;
        overflow: hidden;
    }

    .flip-card-front {
        background-color: #f8f9fa;
        color: black;
    }

    .flip-card-front img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .flip-card-front .placeholder-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background-color: #f8f9fa;
        color: #6c757d;
        font-size: 4rem;
    }

    .flip-card-back {
        background-color: #ffffff;
        color: #333;
        transform: rotateY(180deg);
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: left;
        border: 1px solid #eee;
    }

    .flip-card-back .card-title {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 10px;
        color: #0d6efd;
    }

    .flip-card-back .card-text {
        font-size: 0.95rem;
        color: #555;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 8;
        -webkit-box-orient: vertical;
    }
</style>

<div class="container gallery-page-content py-5">
    <div class="section-title p-3 mt-3 text-center">
        <h2 style="font-family: 'SolaimanLipi', sans-serif">ফটোগ্যালারী</h2>
        <div class="title-shape mx-auto"></div>
    </div>

    <div class="row mb-5 mt-4">
        @if($galleries->count() > 0)
            @foreach($galleries as $gallery)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                @if($gallery->image)
                                    <img src="{{ asset('images/galleries/' . $gallery->image) }}" alt="{{ $gallery->title }}">
                                @else
                                    <div class="placeholder-icon">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flip-card-back">
                                @if($gallery->title)
                                    <h4 class="card-title text-center">{{ $gallery->title }}</h4>
                                    <hr class="w-25 mx-auto mt-1 mb-3" style="background-color: #0d6efd; height: 2px;">
                                @endif

                                @if($gallery->description)
                                    <div class="card-text text-center">
                                        {!! strip_tags($gallery->description) !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <p>No photos available in the gallery at the moment.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@stop