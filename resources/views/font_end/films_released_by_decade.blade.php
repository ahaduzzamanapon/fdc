@extends('welcome')
@section('body')
    <div class="about-header">
        <h1><span style="font-family:SutonnyMJ;font-size:58px">{{ $decade }}</span> দশক ভিত্তিক মুক্তিপ্রাপ্ত চলচ্চিত্র </h1>
    </div>
    <section class="cardSection pb-5" style="background-color: #eaf9fb;">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex align-items-start">
                    @php
                        // 1. Generate decade ranges
                        $currentYear = date('Y');
                        $startDecade = 1960;
                        $decadeRanges = [];
                        while ($startDecade <= $currentYear) {
                            $endYear = $startDecade + 9;
                            if ($endYear > $currentYear) $endYear = $currentYear;
                            $decadeRanges[$startDecade] = [$startDecade, $endYear];
                            $startDecade += 10;
                        }
                        // decade navigation
                        $decadeSequence = array_keys($decadeRanges);
                        $currentIndex = array_search($decade, $decadeSequence);
                        $nextDecade = $decadeSequence[$currentIndex + 1] ?? null;
                        $prevDecade = $decadeSequence[$currentIndex - 1] ?? null;
                        // Get selected decade year range
                        [$startYear, $endYear] = $decadeRanges[$decade];
                    @endphp
                    <!-- LEFT: Year List -->
                    <div class="nav nav-pills flex-column border" role="tablist" style="min-width:150px;">
                        @for($year = $startYear; $year <= $endYear; $year++)
                            <button style="padding: 5px 20px; border-radius:0; border-bottom:1px solid blue"
                                class="nav-link {{ $year === $startYear ? 'active' : '' }}"
                                id="v-pills-{{ $year }}-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#v-pills-{{ $year }}"
                                type="button">
                                <span style="font-family:SutonnyMJ;font-size:18px">{{ $year}}</span> সাল
                            </button>
                        @endfor
                        @if($prevDecade)
                            <a href="{{ route('historyAndHeritageOfCinema.films_released_by_decade', ['decade' => $prevDecade]) }}"
                            style="padding: 5px 20px; border-bottom:1px solid blue;">
                            <i class="fa fa-backward"></i> পূর্ববর্তী দশক
                            </a>
                        @endif
                        @if($nextDecade)
                            <a href="{{ route('historyAndHeritageOfCinema.films_released_by_decade', ['decade' => $nextDecade]) }}"
                            style="padding: 5px 20px; border-bottom:1px solid blue;">
                            পরবর্তী দশক <i class="fa fa-forward"></i>
                            </a>
                        @endif
                    </div>
                @php
                    $cinemaData = [
                        1960 => [
                            // ["tai naki"],
                            [ 'cinema' => 'রাজধানীর বুকে' ,
                                'producer' => 'এহতেশাম',
                                'acting' => 'রহমান, শবনম, চিত্রা সিনহা, সুভাষ দত্ত, নার্গিস, গোলাম মুস্তাফা, আজিম',
                                'type' => '',
                                'publish_date' => '২ সেপ্টেম্বর ১৯৬০',
                                'sign' => '',
                                'info' => '-',
                            ],
                            [
                                'cinema' => 'আসিয়া',
                                'producer' =>'ফতেহ লোহানী',
                                'acting' => 'সুমিতা দেবী, শহীদ, প্রবীর কুমার, ভবেশ মুখার্জী, কাজী খালেক',
                                'type' => '',
                                'publish_date' => '৪ নভেম্বর ১৯৬০',
                                'sign' => 'শ্রেষ্ঠ বাংলা চলচ্চিত্র হিসেবে প্রেসিডেন্ট পুরস্কার লাভ',
                                'info' => '-',
                            ],
                        ],
                        1961 => [
                            [
                                'cinema' => 'যে নদী মরুপথে',
                                'producer' => 'সালাউদ্দিন',
                                'acting' => 'ড. রওশন আরা, খান আতাউর রহমান, ইনাম আহমেদ, সঞ্জীব দত্ত',
                                'type' => '',
                                'publish_date' => '২৮ এপ্রিল ১৯৬১',
                                'sign' => '',
                                'info' => '-',
                            ],
                            [
                                'cinema' => 'হারানো দিন',
                                'producer' => 'মুস্তাফিজ',
                                'acting' => 'রহমান, শবনম, নারায়ণ চক্রবর্তী, আজিম, সুভাষ দত্ত, গোলাম মুস্তাফা',
                                'type' => '',
                                'publish_date' => '৪ আগস্ট ১৯৬১',
                                'sign' => '',
                                'info' => '',
                            ],
                            [
                                'cinema' => 'তোমার আমার',
                                'producer' => 'মহিউদ্দিন',
                                'acting' => 'আমিনুল হক, চিত্রা সিনহা, কাফি খান, সঞ্জীব দত্ত, নারায়ণ চক্রবর্তী, আনোয়ার হোসেন',
                                'type' => '',
                                'publish_date' => '১০ নভেম্বর ১৯৬১',
                                'sign' => '',
                                'info' =>'-',
                            ],
                            [
                                'cinema' => 'কখনো আসেনি',
                                'producer' => 'জহির রায়হান',
                                'acting' => 'সুমিতা দেবী, খান আতাউর রহমান, সঞ্জীব দত্ত, শবনম, কণা, নারায়ণ চক্রবর্তী, মিসবাহউদ্দিন',
                                'type' => 'সামাজিক',
                                'publish_date' => '২৪ নভেম্বর ১৯৬১',
                                'sign' => 'পরিচালক হিসেবে জহির রায়হান এর নির্মিত প্রথম চলচ্চিত্র',
                                'info' => '-',
                            ],
                        ],
                        1962 => [
                            [
                                'cinema' => 'সূর্যস্নান',
                                'producer' =>'সালাহ্উদ্দিন',
                                'acting' => 'ড. রওশন আরা, আনোয়ার হোসেন, নাসিমা খান, আসিয়া, নায়না, মিনতি, সুভাষ দত্ত, কাজী খালেক, মফিজ, ইনাম আহমেদ',
                                'type' => '',
                                'publish_date' => '৫ জানুয়ারি ১৯৬২',
                                'sign' => '',
                                'info' => '-',
                            ],
                            [
                                'cinema' => 'সোনার কাজল',
                                'producer' => 'কলিম শরাফী,জহির রায়হান',
                                'acting' => 'খলিল, সুমিতা দেবী, সুলতানা জামান, সুভাষ দত্ত, কাজী খালেক, খান আতাউর রহমান',
                                'type' => '',
                                'publish_date' => '২৯ জানুয়ারি ১৯৬২',
                                'sign' => '',
                                'info' => '-', ],
                            [
                                'cinema' => 'চান্দা',
                                'producer' => 'এহতেশাম',
                                'acting' => 'রহমান, শবনম, সুলতানা জামান, গোলাম মুস্তাফা, নারায়ণ চক্রবর্তী',
                                'type' => '',
                                'publish_date' => '৩ আগস্ট ১৯৬২',
                                'sign' => 'উর্দু ভাষার চলচ্চিত্র। এ চলচ্চিত্রের মাধ্যমে শবনম ও রহমানের উর্দু চলচ্চিত্রে অভিষেক ঘটে।',
                                'info' => '',
                            ],
                            [
                                'cinema' => 'জোয়ার এলো',
                                'producer' => 'আবদুল জব্বার খান',
                                'acting' => 'সুলতানা জামান, ইনাম আহমেদ, সাইফুদ্দিন, আনোয়ার হোসেন',
                                'type' => '', 'publish_date' => '২৪ আগস্ট ১৯৬২', 'sign' => '', 'info' => '',
                            ],
                            [
                                'cinema' => 'নতুন সুর',
                                'producer' => 'এহতেশাম',
                                'acting' => 'রহমান, ড. রওশন আরা, ইনাম আহমেদ, আজিম, নারায়ণ চক্রবর্তী, সুভাষ দত্ত',
                                'type' => '',
                                'publish_date' => '২৩ নভেম্বর ১৯৬২',
                                'sign' => '',
                                'info' => '',
                            ],
                        ],
                    ];
                // dd($cinemaData["1960"][0]);
                @endphp

                    <!-- RIGHT: Tab Content -->
                    <div class="tab-content flex-grow-1 border ms-3" style="min-width: 400px;">
                        @for($year = $startYear; $year <= $endYear; $year++)
                            <div class="tab-pane fade {{ $year === $startYear ? 'show active' : '' }}"
                                id="v-pills-{{ $year }}" role="tabpanel">
                                @php
                                    $yearText = [
                                        1960 => '১৯৬০ সালে বাংলাদেশের স্বাধীনতা পূর্বে তৎকালীন পূর্ব পাকিস্তানে মুক্তিপ্রপ্ত চলচ্চিত্র সংখ্যা দুইটি ।',
                                        // 1960 => '১৯৬০ সালে বাংলাদেশের স্বাধীনতা পূর্ব তৎকালীন পূর্ব পাকিস্তানে মুক্তিপ্রাপ্ত চলচ্চিত্রের তালিকা। ঐ বছর ঢাকা থেকে মাত্র দুইটি চলচ্চিত্র মুক্তি পায়।',
                                        1961 => '১৯৬১ সালে বাংলাদেশের স্বাধীনতা পূর্বে তৎকালীন পূর্ব পাকিস্তানে মুক্তিপ্রপ্ত চলচ্চিত্র সংখ্যা চারটি ।',
                                        1962 => '১৯৬২ সালে বাংলাদেশের স্বাধীনতা পূর্বে তৎকালীন পূর্ব পাকিস্তানে মুক্তিপ্রপ্ত চলচ্চিত্র সংখ্যা পাঁচটি ।',
                                    ];
                                @endphp

                                <h3 class="text-center mt-2">
                                    <span style="font-family:SutonnyMJ;font-size:33px;font-weight:bold">{{ $year }}</span> সালের চলচ্চিত্রের তালিকা
                                </h3>
                                <h6 class="text-center mt-2">
                                    {{ $yearText[$year] ?? '' }}
                                </h6>

                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-light" style="font-size:14px">
                                            <tr>
                                                <th>#</th>
                                                <th>চলচ্চিত্র</th>
                                                <th>প্রযোজক</th>
                                                <th>পরিচালক</th>
                                                <th>অভিনয়ে</th>
                                                <th>ধরন</th>
                                                <th>মুক্তির তারিখ</th>
                                                <th>অর্জন</th>
                                                {{-- <th>তথ্যসূত্র</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:13px;vertical-align:middle">
                                            @if(isset($cinemaData[$year]) && count($cinemaData[$year]) > 0)
                                                @foreach($cinemaData[$year] as $index => $film)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td style="white-space:nowrap">{{ $film['cinema'] }}</td>
                                                        <td style="white-space:nowrap">{{ $film['nirmata'] }}</td>
                                                        <td style="white-space:nowrap">{{ $film['producer'] }}</td>
                                                        <td>{{ $film['acting'] }}</td>
                                                        <td>{{ $film['type'] }}</td>
                                                        <td style="white-space:nowrap">{{ $film['publish_date'] }}</td>
                                                        <td>{{ $film['sign'] }}</td>
                                                        {{-- <td>{{ $film['info'] }}</td> --}}
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center">এই বছরে কোন সিনেমা পাওয়া যায়নি</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endfor
                    </div> <!-- end tab content -->
                </div>
            </div>
        </div>
    </section>
@stop
