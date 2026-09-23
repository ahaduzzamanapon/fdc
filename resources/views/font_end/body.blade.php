@extends('welcome')

@section('body')
<style>
    a{
        text-decoration: none !important;  
    }
</style>
<section class="heroSection">
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-7 heroLeft">
                    <span class="heroTitle">{{ __('messages.digital_film_management_new_chapter') }}</span>
                    <span class="">{{ __('messages.modern_user_friendly_solution') }}</span>
                </div>
                <div class="col-md-5">
                    <img class="heroImg" src="{{ asset('portal/image/hero.svg') }}" alt="hero.svg" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Notice Ticker Section (Dynamic) -->
@if(isset($notices) && count($notices) > 0)
<section class="notice-ticker-section bg-white border-bottom border-top py-2">
    <div class="container">
        <div class="d-flex align-items-center">
            <span class="badge bg-danger text-white px-3 py-2 mr-3 ms-2 me-3 font-weight-bold fw-bold" style="white-space: nowrap; font-size: 14px;">
                <i class="fas fa-bullhorn mr-1 me-1"></i> নোটিশ:
            </span>
            <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" class="flex-grow-1 text-dark">
                @foreach($notices as $notice)
                    <a href="{{ route('notices.page') }}" class="text-dark mr-4 me-4" style="text-decoration: none;">
                        <span class="font-weight-bold fw-bold">▪ {{ Str::limit($notice->title ?: strip_tags($notice->description), 90) }}</span>
                        <small class="text-muted ml-1 ms-1">({{ \Carbon\Carbon::parse($notice->created_at)->format('d-m-Y') }})</small>
                    </a>
                @endforeach
            </marquee>
            <a href="{{ route('notices.page') }}" class="btn btn-sm btn-outline-primary ml-3 ms-3 text-nowrap" style="white-space: nowrap;">সকল নোটিশ</a>
        </div>
    </div>
</section>
@endif

<!-- card section -->
<section class="cardSection" style="background-color: #eaf9fb; padding-bottom: 55px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p>{{ __('messages.welcome_to_bfdc') }}</p>
            </div>
            <div class="col-md-12 mt-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div>
                                    <img src="{{ asset('portal/image/card2.svg') }}" alt="card2.svg">
                                </div>
                                <div>
                                    <span class="cardTitle">{{ __('messages.tutorial') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div>
                                    <img src="{{ asset('portal/image/card3.svg') }}" alt="card3.svg">
                                </div>
                                <div>
                                    <span class="cardTitle">{{ __('messages.guideline') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('register') }}">
                                <div class="card">
                                    <div>
                                        <img src="{{ asset('portal/image/card1.svg') }}" alt="">
                                    </div>
                                    <div>
                                        <span class="cardTitle">{{ __('messages.register') }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <style>
                        .modified {
                            font-size: 22px !important;
                            text-decoration: none !important;
                        }

                        .modified:hover {
                            text-decoration: none !important;
                        }
                    </style>
                    <div class="row pt-4">
                        <div class="col-md-4">
                            <a href="{{ route('login.custom', 'citizen') }}" class="justify-content-end modified">
                                <div class="card">
                                    <div>
                                        <img src="{{ asset('portal/image/card4.svg') }}" alt="card4.svg">
                                    </div>
                                    <div>
                                        <span class="cardTitle">সেবা সমূহ পেতে প্রবেশ করুন</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('login.custom', 'admin') }}" class="justify-content-end modified">
                                <div class="card">
                                    <div>
                                        <img src="{{ asset('portal/image/card4.svg') }}" alt="card4.svg">
                                    </div>
                                    <div>
                                        <span class="cardTitle">প্রশাসনিক কার্যক্রম</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('noc.create') }}" class="justify-content-end modified">
                                <div class="card">
                                    <div>
                                        <img src="{{ asset('portal/image/card4.svg') }}" alt="card4.svg">
                                    </div>
                                    <div>
                                        <span class="cardTitle">NOC আবেদন</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Photo Gallery Preview Section (Dynamic) -->
@if(isset($galleries) && count($galleries) > 0)
<section class="gallery-preview-section py-5" style="background-color: #ffffff;">
    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-8">
                <h3 class="font-weight-bold fw-bold text-dark m-0" style="font-family: 'SolaimanLipi', sans-serif">ফটোগ্যালারী</h3>
                <div style="width: 50px; height: 3px; background-color: #0d6efd; margin-top: 5px;"></div>
            </div>
            <div class="col-4 text-right text-end">
                <a href="{{ route('photo_gallery.page') }}" class="btn btn-outline-primary btn-sm">সব দেখুন <i class="fas fa-arrow-right ml-1 ms-1"></i></a>
            </div>
        </div>
        <div class="row g-3">
            @foreach($galleries->take(3) as $gallery)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm border-0 rounded overflow-hidden" style="transition: transform 0.3s ease;">
                        <div style="height: 200px; overflow: hidden; background-color: #f8f9fa;">
                            @if($gallery->image)
                                <img src="{{ asset('images/galleries/' . $gallery->image) }}" class="card-img-top w-100 h-100" style="object-fit: cover;" alt="{{ $gallery->title ?? 'Gallery Photo' }}" loading="lazy">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                    <i class="fas fa-image fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        @if($gallery->title || $gallery->description)
                            <div class="card-body p-3">
                                @if($gallery->title)
                                    <h6 class="card-title font-weight-bold fw-bold mb-1 text-truncate">{{ $gallery->title }}</h6>
                                @endif
                                @if($gallery->description)
                                    <p class="card-text text-muted small mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{!! strip_tags($gallery->description) !!}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- contact section -->
<section class="cardSection" style="background-color: #eaf9fb; padding-bottom: 45px;">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="row">
                        <div class="container">
                            <p class="S_Title">{{ __('messages.contact') }}</p>
                            <div class="col-md-12"
                                style="background-image: url('{{ asset('portal/image/contact.svg') }}');overflow: hidden;padding: 0px;background-repeat: no-repeat;background-size: cover;background-position: 38%;overflow-x: hidden;margin-top: 29px;">
                                <div class="row">
                                    <form id="contactForm">
                                        @csrf
                                        <div class="col-md-12">
                                            <input type="text" name="name" class="inputField" id="name"
                                                placeholder="{{ __('messages.name') }}" required>
                                        </div>
                                        <div class="col-md-12">
                                            <input type="email" name="email" class="inputField" id="email"
                                                placeholder="{{ __('messages.email') }}" required>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea name="message" class="inputField" id="message"
                                                placeholder="{{ __('messages.message') }}" required></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="inpusubmitField"
                                                id="submitBtn">{{ __('messages.send') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop

@push('fontEnd_script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#contactForm').on('submit', function (e) {
                e.preventDefault();

                let submitBtn = $('#submitBtn');
                submitBtn.prop('disabled', true).text('Sending...');

                $.ajax({
                    url: "{{ route('contact.submit') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'সফল!',
                            text: response.message,
                            confirmButtonText: 'ঠিক আছে'
                        });
                        $('#contactForm')[0].reset();
                    },
                    error: function (xhr) {
                        let errorMsg = 'কিছু সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'ত্রুটি!',
                            text: errorMsg,
                            confirmButtonText: 'ঠিক আছে'
                        });
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).text("{{ __('messages.send') }}");
                    }
                });
            });
        });
    </script>
@endpush