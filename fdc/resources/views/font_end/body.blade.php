@extends('welcome')

@section('body')
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

    <!-- card section -->
    <section class="cardSection" style="background-color: #eaf9fb;">
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
                                        <div class="col-md-12">
                                            <input type="text" name="name" class="inputField" id="name"
                                                placeholder="{{ __('messages.name') }}">
                                        </div>
                                        <div class="col-md-12">
                                            <input type="email" name="email" class="inputField" id="email"
                                                placeholder="{{ __('messages.email') }}">
                                        </div>
                                        <div class="col-md-12">
                                            <textarea name="message" class="inputField" id=""
                                                placeholder="{{ __('messages.message') }}"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="inpusubmitField"
                                                id="submit">{{ __('messages.send') }}</button>
                                        </div>
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
