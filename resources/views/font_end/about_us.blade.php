@extends('welcome')
@section('body')


    <style>
        /* Modern gradient header */
        .about-header {
            background: linear-gradient(135deg, #e64848, #0091ff);
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        .about-header h1 {
            font-size: 48px;
            font-weight: 700;
        }

        .section-title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .icon-box {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
            height: 100%;
        }

        .icon-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .team-card img {
            border-radius: 50%;
            width: 130px;
            height: 130px;
            object-fit: cover;
            margin-bottom: 15px;
        }

        footer {
            background: #1f2937;
            padding: 25px 0;
        }

        .team-card {
            transition: 0.3s;
            background: #ffffff;
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .team-img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            transition: 0.3s;
        }

        .team-card:hover .team-img {
            transform: scale(1.05);
        }

        .carousel-indicators button {
            width: 12px !important;
            height: 12px !important;
            border-radius: 50%;
            background-color: #4f46e5 !important;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
        }

    </style>

    <!-- Header / Banner Section -->
    <div class="about-header">
        <h1>{{ $aboutUs->banner_title ?? 'আমাদের সম্পর্কে' }}</h1>
        @if(!empty($aboutUs->banner_subtitle))
            <p class="mt-3 container">{{ $aboutUs->banner_subtitle }}</p>
        @endif
    </div>

    <section class="cardSection pb-5" style="background-color: #eaf9fb;">
        <div class="container">
            <div class="row">
                <!-- Main About Section -->
                <div class="col-md-12">
                    <h1 class="text-center">{{ $aboutUs->main_title ?? 'আমাদের সম্পর্কে' }}</h1>
                </div>
                <div class="container py-5">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <p class="text-justify">
                                {!! nl2br(e($aboutUs->main_description ?? '')) !!}
                            </p>
                        </div>
                        <div class="col-lg-6 text-center">
                            @if(!empty($aboutUs->main_image))
                                <img src="{{ \Illuminate\Support\Str::startsWith($aboutUs->main_image, 'http') ? $aboutUs->main_image : asset($aboutUs->main_image) }}" class="img-fluid rounded shadow" alt="About Image">
                            @else
                                <img src="{{ asset('/assets/images/about.png') }}" class="img-fluid rounded shadow" alt="About Image">
                            @endif
                        </div>
                    </div>
                </div>

                <!-- WHAT WE DO / FEATURES -->
                @if(isset($features) && count($features) > 0)
                <div class="container py-5">
                    <div class="row g-4 justify-content-center">
                        @foreach($features as $feature)
                        <div class="col-md-4">
                            <div class="icon-box">
                                <h5>{{ $feature->title }}</h5>
                                @if(!empty($feature->items))
                                    @php
                                        $itemList = array_filter(explode("\n", str_replace("\r", "", $feature->items)));
                                    @endphp
                                    <ul>
                                        @foreach($itemList as $item)
                                            <li>{{ trim($item) }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- TEAM / OFFICERS SECTION (DYNAMIC) -->
                @if(isset($officers) && count($officers) > 0)
                <div class="container py-5">
                    <h2 class="section-title text-center mb-4">{{ $aboutUs->team_title ?? 'কর্মকর্তাবৃন্দ' }}</h2>
                    <div id="teamCarousel" class="carousel slide" data-bs-ride="carousel" data-ride="carousel">
                        <!-- Carousel Inner -->
                        <div class="carousel-inner">
                            @foreach($officers as $index => $officer)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="row justify-content-center">
                                    <div class="col-md-4 col-lg-3 text-center">
                                        <div class="team-card p-4 shadow rounded">
                                            @if(!empty($officer->image))
                                                <img src="{{ \Illuminate\Support\Str::startsWith($officer->image, 'http') ? $officer->image : asset($officer->image) }}" class="team-img" alt="{{ $officer->name }}">
                                            @else
                                                <img src="{{ asset('/assets/images/user.png') }}" class="team-img" alt="{{ $officer->name }}">
                                            @endif
                                            <h5 class="mt-3">{{ $officer->name }}</h5>
                                            <h6>{{ $officer->designation }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Controls -->
                        @if(count($officers) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#teamCarousel" data-target="#teamCarousel" data-bs-slide="prev" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#teamCarousel" data-target="#teamCarousel" data-bs-slide="next" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>

                        <!-- Indicators -->
                        <div class="carousel-indicators position-relative mt-4">
                            @foreach($officers as $index => $officer)
                                <button type="button" data-bs-target="#teamCarousel" data-target="#teamCarousel" data-bs-slide-to="{{ $index }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></button>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>
@stop
