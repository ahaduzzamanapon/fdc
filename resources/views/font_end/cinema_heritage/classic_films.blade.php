@extends('welcome')
@section('body')

    <style>
        .heritage-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .heritage-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .heritage-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .heritage-card-body {
            padding: 20px;
        }

        .heritage-badge {
            background-color: #ebf5ff;
            color: #1a56db;
            font-size: 13px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .heritage-lazy-item {
            animation: heritageFadeIn 0.5s ease-in-out forwards;
        }

        @keyframes heritageFadeIn {
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

    @php
        $heroRightImg = (!empty($page->banner_image) && !\Illuminate\Support\Str::contains($page->banner_image, 'unsplash.com'))
            ? (\Illuminate\Support\Str::startsWith($page->banner_image, 'http') ? $page->banner_image : asset($page->banner_image))
            : asset('portal/image/hero_classic.svg');
    @endphp

    <!-- Hero Header Section (Content inside Hero Section) -->
    <section class="heroSection">
        <div class="container">
            <div class="col-md-12">
                <div class="row align-items-center">
                    <div class="col-md-7 heroLeft">
                        <span class="heroTitle text-white">{{ $page->title ?? 'কালজয়ী বাংলা চলচ্চিত্র' }}</span>
                        @if(!empty($page->main_description))
                            <span class="heroDesc text-light" style="color: #ffffff !important; font-size: 16px; line-height: 1.6;">
                                {!! nl2br(e($page->main_description)) !!}
                            </span>
                        @elseif(!empty($page->banner_subtitle))
                            <span class="heroDesc text-light" style="color: #ffffff !important;">{{ $page->banner_subtitle }}</span>
                        @endif
                    </div>
                    <div class="col-md-5 text-center my-3 my-md-0">
                        <img class="heroImg img-fluid" src="{{ $heroRightImg }}" alt="hero_classic.svg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-5" style="background-color: #f8fafc;">
        <div class="container">
            <!-- Items Grid -->
            @if(isset($page->items) && count($page->items) > 0)
                <div class="row g-4" id="heritage-grid">
                    @foreach($page->items as $index => $item)
                        @php
                            $defaultImg = 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=600&auto=format&fit=crop&q=80';
                            $imgSrc = !empty($item->image) ? (\Illuminate\Support\Str::startsWith($item->image, 'http') ? $item->image : asset($item->image)) : $defaultImg;
                        @endphp
                        <div class="col-md-6 col-lg-4 heritage-item-col {{ $index >= 9 ? 'd-none' : '' }}" data-item-index="{{ $index }}">
                            <div class="heritage-card">
                                <img src="{{ $imgSrc }}" alt="{{ $item->title }}" loading="lazy" onerror="this.onerror=null;this.src='{{ $defaultImg }}';">
                                <div class="heritage-card-body">
                                    @if(!empty($item->sub_title))
                                        <span class="heritage-badge">{{ $item->sub_title }}</span>
                                    @endif
                                    <h4 class="h5 font-weight-bold mb-2">{{ $item->title }}</h4>
                                    @if(!empty($item->description))
                                        <p class="text-muted mb-0">{!! nl2br(e($item->description)) !!}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(count($page->items) > 9)
                    <!-- Auto Load Sentinel -->
                    <div id="infinite-scroll-sentinel" class="text-center py-4 mt-4">
                        <div id="auto-load-spinner" class="spinner-border text-primary d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div id="all-loaded-msg" class="d-none">
                            <span class="badge bg-secondary px-3 py-2 fs-6 rounded-pill">সবগুলো চলচ্চিত্র প্রদর্শিত হচ্ছে</span>
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <p class="text-muted fs-5">কোনো তথ্য পাওয়া যায়নি।</p>
                </div>
            @endif
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemsPerBatch = 6;
            const sentinel = document.getElementById('infinite-scroll-sentinel');
            const spinner = document.getElementById('auto-load-spinner');
            const allLoadedMsg = document.getElementById('all-loaded-msg');

            if (!sentinel) return;

            let isLoading = false;

            function loadNextBatch() {
                const hiddenItems = document.querySelectorAll('.heritage-item-col.d-none');

                if (hiddenItems.length === 0) {
                    if (spinner) spinner.classList.add('d-none');
                    if (allLoadedMsg) allLoadedMsg.classList.remove('d-none');
                    if (observer) observer.disconnect();
                    return;
                }

                isLoading = true;
                if (spinner) spinner.classList.remove('d-none');

                setTimeout(function () {
                    let count = 0;
                    hiddenItems.forEach(function (item) {
                        if (count < itemsPerBatch) {
                            item.classList.remove('d-none');
                            item.classList.add('heritage-lazy-item');
                            count++;
                        }
                    });

                    if (spinner) spinner.classList.add('d-none');
                    isLoading = false;

                    const remainingHidden = document.querySelectorAll('.heritage-item-col.d-none');
                    if (remainingHidden.length === 0) {
                        if (allLoadedMsg) allLoadedMsg.classList.remove('d-none');
                        if (observer) observer.disconnect();
                    }
                }, 300);
            }

            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting && !isLoading) {
                        loadNextBatch();
                    }
                });
            }, {
                rootMargin: '150px'
            });

            observer.observe(sentinel);
        });
    </script>
@stop
