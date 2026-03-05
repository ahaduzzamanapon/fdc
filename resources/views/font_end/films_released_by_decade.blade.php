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
                        $cinemaData = [];
                        foreach ($films as $film) {
                            $year = substr($film->release_date, 0, 4); // Extract year from release_date, or use film_year if it exists
                            if (!isset($cinemaData[$year])) {
                                $cinemaData[$year] = [];
                            }
                            $cinemaData[$year][] = $film;
                        }
                    @endphp
                    <!-- RIGHT: Tab Content -->
                    <div class="tab-content flex-grow-1 border ms-3" style="min-width: 400px;">
                        @for($year = $startYear; $year <= $endYear; $year++)
                            <div class="tab-pane fade {{ $year === $startYear ? 'show active' : '' }}"
                                id="v-pills-{{ $year }}" role="tabpanel">
                                @php
                                    $yearText = [
                                        1960 => '১৯৬০ সালে বাংলাদেশের স্বাধীনতা পূর্বে তৎকালীন পূর্ব পাকিস্তানে মুক্তিপ্রপ্ত চলচ্চিত্র সংখ্যা দুইটি ।',
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
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:13px;vertical-align:middle">
                                            @if(isset($cinemaData[$year]) && count($cinemaData[$year]) > 0)

                                                @foreach($cinemaData[$year] as $index => $film)

                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td style="white-space:nowrap">
                                                            {{ $film->film_name }}
                                                        </td>
                                                        <td style="white-space:nowrap">
                                                            {{ $film->producer_name }}
                                                        </td>
                                                        <td style="white-space:nowrap">
                                                            {{ $film->director_name }}
                                                        </td>
                                                        <td>
                                                            {{ $film->acting }}
                                                        </td>
                                                        <td>
                                                            {{ $film->type }}
                                                        </td>
                                                        <td style="white-space:nowrap;font-family:SutonnyMJ;">
                                                            {{ convertToBengaliDate($film->release_date) }}
                                                        </td>
                                                        <td>
                                                            {{ $film->achivements }}
                                                        </td>
                                                    </tr>

                                                @endforeach

                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        এই বছরে কোন সিনেমা পাওয়া যায়নি
                                                    </td>
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
