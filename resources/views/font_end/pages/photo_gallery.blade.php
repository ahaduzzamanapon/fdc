@extends('welcome')
@section('title', 'ফটোগ্যালারী')

@section('body')
<style>
    .gallery-page-content .section-title {
        text-align: center !important;
        margin-bottom: 30px;
    }

    .gallery-page-content .title-shape {
        width: 60px;
        height: 4px;
        background-color: #0d6efd;
        margin-top: 10px;
        border-radius: 2px;
    }

    /* 3D Flip Card CSS */
    .flip-card {
        background-color: transparent;
        width: 100%;
        height: 320px;
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
        -webkit-transform-style: preserve-3d;
        border-radius: 12px;
    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
        -webkit-transform: rotateY(180deg);
    }

    .flip-card-front,
    .flip-card-back {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Front Side */
    .flip-card-front {
        background-color: #f8f9fa;
        color: #000000;
        transform: rotateY(0deg);
        -webkit-transform: rotateY(0deg);
        overflow: hidden;
    }

    .flip-card-front img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .flip-card-front .front-title-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.4) 70%, transparent 100%);
        color: #ffffff;
        padding: 20px 15px 12px 15px;
        text-align: left;
    }

    .flip-card-front .front-title-overlay h5 {
        font-size: 1.05rem;
        font-weight: 600;
        margin: 0;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
    }

    .flip-card-front .placeholder-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background-color: #eaf9fb;
        color: #0d6efd;
        font-size: 4rem;
    }

    /* Back Side */
    .flip-card-back {
        background-color: #ffffff;
        color: #212529;
        transform: rotateY(180deg);
        -webkit-transform: rotateY(180deg);
        padding: 25px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        border: 2px solid #0d6efd;
        box-sizing: border-box;
    }

    .flip-card-back .card-title {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: #0d6efd;
    }

    .flip-card-back .card-text {
        font-size: 0.95rem;
        color: #212529;
        line-height: 1.6;
        margin-top: 5px;
        word-break: break-word;
    }

    /* Fade-in Animation for Lazy Loaded Items */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container gallery-page-content py-5">
    <div class="section-title p-2 mt-2 text-center">
        <h2 class="fw-bold" style="font-family: 'SolaimanLipi', sans-serif; color: #2b303a;">ফটোগ্যালারী</h2>
        <div class="title-shape mx-auto"></div>
        <p class="text-muted mt-2 small">বাংলাদেশ চলচ্চিত্র উন্নয়ন কর্পোরেশন (বিএফডিসি)-এর স্থিরচিত্রসমূহ</p>
    </div>

    <div class="row mb-4 mt-4" id="gallery-container">
        @if($galleries->count() > 0)
            @foreach($galleries as $index => $gallery)
                <!-- First 3 rows (9 items, index 0 to 8) visible initially; subsequent items lazy loaded on scroll -->
                <div class="col-lg-4 col-md-6 mb-4 gallery-card-item {{ $index >= 9 ? 'd-none gallery-lazy-item' : '' }}" data-index="{{ $index }}">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                @if($gallery->image)
                                    <img src="{{ asset('images/galleries/' . $gallery->image) }}" alt="{{ $gallery->title }}" loading="lazy" width="400" height="320">
                                @else
                                    <div class="placeholder-icon">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                @if($gallery->title)
                                    <div class="front-title-overlay">
                                        <h5 class="text-truncate" style="font-family: 'SolaimanLipi', sans-serif;">{{ $gallery->title }}</h5>
                                    </div>
                                @endif
                            </div>
                            <div class="flip-card-back">
                                @if($gallery->title)
                                    <h4 class="card-title" style="font-family: 'SolaimanLipi', sans-serif;">{{ $gallery->title }}</h4>
                                    <div style="width: 40px; height: 3px; background-color: #0d6efd; margin: 8px auto 14px auto; border-radius: 2px;"></div>
                                @endif

                                @if($gallery->description)
                                    <p class="card-text" style="font-family: 'SolaimanLipi', sans-serif;">
                                        {!! strip_tags($gallery->description) !!}
                                    </p>
                                @else
                                    <p class="card-text text-muted" style="font-family: 'SolaimanLipi', sans-serif;">
                                        কোনো বিস্তারিত তথ্য উপলব্ধ নেই।
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <p class="m-0">কোনো ফটোগ্যালারী পাওয়া যায়নি।</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Lazy Loading Sentinel & Spinner -->
    @if($galleries->count() > 9)
        <div id="lazy-load-sentinel" class="text-center my-4 py-3">
            <div id="lazy-spinner" class="d-none">
                <div class="spinner-border text-primary" role="status" style="width: 2.2rem; height: 2.2rem;">
                    <span class="sr-only visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-2 small" style="font-family: 'SolaimanLipi', sans-serif;">আরও ছবি লোড হচ্ছে...</p>
            </div>
            <button id="load-more-btn" class="btn btn-outline-primary px-4 py-2 rounded-pill fw-bold" style="font-family: 'SolaimanLipi', sans-serif;">
                আরও ছবি দেখুন <i class="fas fa-chevron-down ms-1"></i>
            </button>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hiddenItems = Array.from(document.querySelectorAll('.gallery-lazy-item'));
    const sentinel = document.getElementById('lazy-load-sentinel');
    const spinner = document.getElementById('lazy-spinner');
    const loadMoreBtn = document.getElementById('load-more-btn');

    if (!sentinel || hiddenItems.length === 0) return;

    const batchSize = 6; // Load 2 rows (6 items) per batch

    function loadNextBatch() {
        if (hiddenItems.length === 0) return;

        if (spinner) spinner.classList.remove('d-none');
        if (loadMoreBtn) loadMoreBtn.classList.add('d-none');

        setTimeout(function() {
            const nextBatch = hiddenItems.splice(0, batchSize);
            nextBatch.forEach(function(item) {
                item.classList.remove('d-none');
                item.style.animation = 'fadeInUp 0.5s ease forwards';
            });

            if (spinner) spinner.classList.add('d-none');

            if (hiddenItems.length > 0) {
                if (loadMoreBtn) loadMoreBtn.classList.remove('d-none');
                if (observer) observer.observe(sentinel);
            } else {
                if (sentinel) sentinel.style.display = 'none';
            }
        }, 400);
    }

    let observer;
    if ('IntersectionObserver' in window) {
        observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting && hiddenItems.length > 0) {
                    observer.unobserve(sentinel);
                    loadNextBatch();
                }
            });
        }, {
            rootMargin: '120px'
        });

        observer.observe(sentinel);
    }

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            if (observer) observer.unobserve(sentinel);
            loadNextBatch();
        });
    }
});
</script>
@stop