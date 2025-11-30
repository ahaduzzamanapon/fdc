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
            color: #fff;
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

    </style>
    
    <!-- card section -->
    <div class="about-header">
        <h1>আমাদের সম্পর্কে</h1>
        <p class="mt-3 container">একটি আধুনিক ও ইউজার-ফ্রেন্ডলি সল্যুশন, যা চলচ্চিত্র নির্মাতাদের জন্য এনেছে এক ছাদের নিচে সব সুবিধা। আপনার প্রোডাকশন, এখন সম্পূর্ণ ডিজিটালি নিয়ন্ত্রিত।প্রযোজকদের জন্য তৈরি একটি সহজ ও কার্যকর সফটওয়্যার</p>
    </div>
    <section class="cardSection pb-5" style="background-color: #eaf9fb;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">{{ __('আমাদের সম্পর্কে') }}</h1>
                </div>
                <div class="container py-5">
                    <div class="row align-iitems-center">
                        <div class="col-lg-6">`
                            <p class="text-justify">
                                একটি আধুনিক ও ইউজার-ফ্রেন্ডলি সল্যুশন, যা চলচ্চিত্র নির্মাতাদের জন্য এনেছে এক ছাদের নিচে সব সুবিধা। আপনার প্রোডাকশন, এখন সম্পূর্ণ ডিজিটালি নিয়ন্ত্রিত।প্রযোজকদের জন্য তৈরি একটি সহজ ও কার্যকর সফটওয়্যার.
                            </p>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="{{asset('/assets/images/about.png')}}" class="img-fluid rounded shadow">
                        </div>
                    </div>
                </div>

                <!-- WHAT WE DO -->
                <div class="container py-5">

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="icon-box">
                                <h5>এফডিসি</h5>
                                <ul>
                                    <li>বিএফডিসি সাংগঠনিক কাঠামো ১৯৮৪ (এনাম কমিটি)</li>
                                    <li>মুক্তি প্রাপ্ত বাংলা চলচ্চিত্রের তালিকা (১৯৫৬-২০২৪)</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="icon-box">
                                <h5>এফডিসি</h5>
                                <ul>
                                    <li>বিএফডিসি সাংগঠনিক কাঠামো ১৯৮৪ (এনাম কমিটি)</li>
                                    <li>মুক্তি প্রাপ্ত বাংলা চলচ্চিত্রের তালিকা (১৯৫৬-২০২৪)</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="icon-box">
                                <h5>এফডিসি</h5>
                                <ul>
                                    <li>বিএফডিসি সাংগঠনিক কাঠামো ১৯৮৪ (এনাম কমিটি)</li>
                                    <li>মুক্তি প্রাপ্ত বাংলা চলচ্চিত্রের তালিকা (১৯৫৬-২০২৪)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TEAM SECTION -->
                <div class="container py-5">
                    <h2 class="section-title text-center mb-4">জনবল</h2>
                    <div id="teamCarousel" class="carousel slide" data-bs-ride="carousel">  
                        <!-- Carousel Inner -->
                        <div class="carousel-inner">

                            <!-- Slide 1 -->
                            <div class="carousel-item active">
                                <div class="row justify-content-center">
                                    <div class="col-md-3 text-center">
                                        <div class="team-card p-4 shadow rounded">
                                            <img src="https://fdc.portal.gov.bd/sites/default/files/files/fdc.portal.gov.bd/npfblock//2025-02-26-15-05-c1bf9124772d8faf3b96b4936734d2a3.jpeg" class="team-img" alt="">
                                            <h5 class="mt-3">মোঃ মাহফুজ আলম</h5>
                                            <h6>মাননীয় উপদেষ্টা (তথ্য ও সম্প্রচার মন্ত্রণালয়)</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2 -->
                            <div class="carousel-item">
                                <div class="row justify-content-center">
                                    <div class="col-md-3 text-center">
                                        <div class="team-card p-4 shadow rounded">
                                            <img src="https://fdc.portal.gov.bd/sites/default/files/files/fdc.portal.gov.bd/npfblock//2024-10-24-14-31-ef71a0c41b7565ef866afe9702a7c43e.jpg" class="team-img" alt="">
                                            <h5 class="mt-3">মাহবুবা ফারজানা</h5>
                                            <h6>সচিব (তথ্য ও সম্প্রচার মন্ত্রণালয়)</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 3 -->
                            <div class="carousel-item">
                                <div class="row justify-content-center">
                                    <div class="col-md-3 text-center">
                                        <div class="team-card p-4 shadow rounded">
                                            <img src="https://fdc.portal.gov.bd/sites/default/files/files/fdc.portal.gov.bd/npfblock//2025-02-26-14-58-d24e5616da518d26f3331b5ca7b9c1e8.jpeg" class="team-img" alt="">
                                            <h5 class="mt-3">মাসুমা রহমান তানি</h5>
                                            <h6>তথ্য ও সম্প্রচার মন্ত্রণালয়</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#teamCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#teamCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>

                        <!-- Indicators -->
                        <div class="carousel-indicators position-relative mt-4">
                            <button type="button" data-bs-target="#teamCarousel" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#teamCarousel" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#teamCarousel" data-bs-slide-to="2"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
