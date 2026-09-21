@extends('welcome')
@section('body')

    <style>
        .heritage-header {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            padding: 70px 0;
            color: white;
            text-align: center;
        }

        .heritage-header h1 {
            font-size: 42px;
            font-weight: 700;
        }

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
    </style>

    <!-- Header Section -->
    <div class="heritage-header">
        <h1>{{ $page->title ?? 'কালজয়ী বাংলা চলচ্চিত্র' }}</h1>
        @if(!empty($page->banner_subtitle))
            <p class="mt-3 container fs-5" style="max-width: 800px;">{{ $page->banner_subtitle }}</p>
        @endif
    </div>

    <!-- Content Section -->
    <section class="py-5" style="background-color: #f8fafc;">
        <div class="container">
            @if(!empty($page->main_description))
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-10 text-center">
                        <p class="lead text-secondary">
                            {!! nl2br(e($page->main_description)) !!}
                        </p>
                    </div>
                </div>
            @endif

            @if(!empty($page->banner_image))
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-10 text-center">
                        <img src="{{ \Illuminate\Support\Str::startsWith($page->banner_image, 'http') ? $page->banner_image : asset($page->banner_image) }}" class="img-fluid rounded shadow" alt="{{ $page->title }}">
                    </div>
                </div>
            @endif

            <!-- Items Grid -->
            @if(isset($page->items) && count($page->items) > 0)
                <div class="row g-4">
                    @foreach($page->items as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="heritage-card">
                                @if(!empty($item->image))
                                    <img src="{{ \Illuminate\Support\Str::startsWith($item->image, 'http') ? $item->image : asset($item->image) }}" alt="{{ $item->title }}">
                                @endif
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
            @else
                <div class="text-center py-5">
                    <p class="text-muted fs-5">কোনো তথ্য পাওয়া যায়নি।</p>
                </div>
            @endif
        </div>
    </section>
@stop
