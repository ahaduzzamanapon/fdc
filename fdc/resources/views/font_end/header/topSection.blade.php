    <nav class="navbar sticky-top navbar-expand-lg">
        <div class="container p-0">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('portal/image/logo.svg') }}" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <style>
                /* Base Menu Styling */
                .custom-menu {
                    background: #ffffff;
                    padding: 0;
                    margin: 0;
                    list-style: none;
                    display: flex;
                    gap: 25px;
                    position: relative;
                }

                .custom-menu .nav-item {
                    position: relative;
                }
                a{
                    text-decoration: none;
                }

                .custom-menu .nav-link {
                    color: #222;
                    font-weight: 600;
                    padding: 12px 16px;
                    text-decoration: none;
                    display: block;
                    transition: 0.3s ease;
                    font-size: 15px;
                }

                .custom-menu .nav-link:hover {
                    color: #0d6efd;
                }

                /* Main Dropdown */
                .submenu {
                    list-style: none;
                    padding: 10px 0;
                    margin: 0;
                    background: #fff;
                    border-radius: 8px;
                    position: absolute;
                    top: 48px;
                    left: 0;
                    width: 260px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                    opacity: 0;
                    visibility: hidden;
                    transform: translateY(10px);
                    transition: 0.3s ease;
                    z-index: 999;
                }

                .nav-item:hover > .submenu {
                    opacity: 1;
                    visibility: visible;
                    transform: translateY(0);
                }

                .submenu li a {
                    display: block;
                    padding: 10px 18px;
                    color: #333;
                    font-size: 14px;
                    transition: 0.3s ease;
                }

                .submenu li a:hover {
                    background: #f2f4f8;
                    color: #0d6efd;
                }

                /* Sub-submenu */
                .has-submenu2 {
                    position: relative;
                }

                .submenu2 {
                    list-style: none;
                    padding: 10px 0;
                    margin: 0;
                    background: #fff;
                    border-radius: 8px;
                    position: absolute;
                    left: 260px;
                    top: 0;
                    width: 200px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                    opacity: 0;
                    visibility: hidden;
                    transform: translateX(10px);
                    transition: 0.3s ease;
                }

                .has-submenu2:hover > .submenu2 {
                    opacity: 1;
                    visibility: visible;
                    transform: translateX(0);
                }

                /* Arrow indicator */
                .has-submenu > a::after,
                .has-submenu2 > a::after {
                    /* content: "▾"; */
                    font-size: 12px;
                    margin-left: 6px;
                    transition: 0.3s ease;
                }

                .has-submenu:hover > a::after,
                .has-submenu2:hover > a::after {
                    transform: rotate(180deg);
                }

                /* Mobile Responsive */
                @media (max-width: 768px) {
                    .custom-menu {
                        flex-direction: column;
                        gap: 0;
                    }

                    .submenu,
                    .submenu2 {
                        position: relative;
                        width: 100%;
                        box-shadow: none;
                    }

                    .submenu2 {
                        left: 0;
                    }

                    .nav-item:hover > .submenu,
                    .has-submenu2:hover > .submenu2 {
                        transform: none;
                    }
                }

            </style>

            <div class="collapse navbar-collapse" id="navbarSupportedContent"
                style="z-index: 999999; background: white;">
                <ul class="fontSize navbar-nav mr-auto w-100 justify-content-center nav-100 custom-menu">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about_us') }}">{{ __('messages.about_us') }}</a>
                    </li>

                    <li class="nav-item has-submenu">
                        <a class="nav-link" href="#">{{ __('চলচ্চিত্রের ইতিহাস ও ঐতিহ্য') }}</a>

                        <ul class="submenu">
                            <!-- Submenu item WITH sub-submenu -->
                            <li class="has-submenu2">
                                <a class="nav-link" href="#">দশক ভিত্তিক মুক্তিপ্রাপ্ত চলচ্চিত্র</a>
                                <!-- Sub-submenu -->
                                <ul class="submenu2">
                                    <li><a href="{{route('historyAndHeritageOfCinema.films_released_by_decade', ['decade' => '1960'])}}">৬০ দশক</a></li>
                                    <li><a href="{{route('historyAndHeritageOfCinema.films_released_by_decade', ['decade' => '1970'])}}">৭০ দশক</a></li>
                                    <li><a href="{{route('historyAndHeritageOfCinema.films_released_by_decade', ['decade' => '1980'])}}">৮০র দশক</a></li>
                                    <li><a href="{{route('historyAndHeritageOfCinema.films_released_by_decade', ['decade' => '1990'])}}">৯০ এর দশক</a></li>
                                    <li><a href="{{route('historyAndHeritageOfCinema.films_released_by_decade', ['decade' => '2000'])}}">২০০০ দশক</a></li>
                                    <li><a href="{{route('historyAndHeritageOfCinema.films_released_by_decade', ['decade' => '2010'])}}">২০১০ দশক</a></li>
                                    <li><a href="{{route('historyAndHeritageOfCinema.films_released_by_decade', ['decade' => '2020'])}}">২০২০ দশক</a></li>
                                </ul>
                            </li>

                            <li><a class="nav-link" href="#">কালজয়ী বাংলা চলচ্চিত্র</a></li>
                            <li><a class="nav-link" href="#">বছরভিত্তিক সর্বোচ্চ ব্যবসাসফল সিনেমা</a></li>

                            <li class="has-submenu2">
                                <a class="nav-link" href="#">জাতীয় চলচ্চিত্র পুরস্কার</a>
                                <ul class="submenu2">
                                    <li><a href="#">৭০ দশক</a></li>
                                    <li><a href="#">৮০র দশক</a></li>
                                    <li><a href="#">৯০ এর দশক</a></li>
                                    <li><a href="#">২০০০ দশক</a></li>
                                    <li><a href="#">২০১০ দশক</a></li>
                                    <li><a href="#">২০২০ দশক</a></li>
                                </ul>
                            </li>
                            <li><a class="nav-link" href="#">আন্তর্জাতিক পর্যায়ে বাংলা চলচ্চিত্র</a></li>
                        </ul>
                    </li>

                    <li class="nav-item has-submenu">
                        <a class="nav-link" href="#">{{ __('গ্যালারি') }}</a>

                        <ul class="submenu">
                            <li><a class="nav-link" href="#">সিনেমা ফটোগ্যালারি</a></li>
                            <li><a class="nav-link" href="#">ফটোগ্যালারী</a></li>
                        </ul>
                    </li>

                    <li class="nav-item has-submenu">
                        <a class="nav-link" href="#">{{ __('আমাদের সেবাসমূহ') }}</a>

                        <ul class="submenu">
                            <li><a class="nav-link" href="#">সেবার তালিকা</a></li>
                            <li><a class="nav-link" href="{{route('noc.create')}}">NOC আবেদন</a></li>
                            <li><a class="nav-link" href="{{route('rate_card')}}" target="_blank">রেট কার্ড (Rate Card)</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('নোটিশ') }}</a>
                    </li>
                </ul>

                @if (Auth::check())
                    <a href="{{ url('/dashboard') }}" class="login_btn justify-content-end"><img
                            src="{{ asset('portal/image/login_icon.svg') }}" alt="">{{ __('messages.dashboard') }}</a>

                @else
                    {{-- <a href="{{ url('/login') }}" class="login_btn justify-content-end"><img
                            src="{{ asset('portal/image/login_icon.svg') }}" alt="">{{ __('লগইন ') }}</a> --}}
                @endif
            </div>
        </div>
    </nav>
