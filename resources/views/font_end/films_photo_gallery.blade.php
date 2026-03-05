@extends('welcome')
@section('body')
    <div class="about-header">
        <h1><span style="font-family:SutonnyMJ;font-size:58px">{{ $decade }}</span> দশক ভিত্তিক মুক্তিপ্রাপ্ত চলচ্চিত্রের স্থিরচিত্র </h1>
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
                            <a href="{{ route('filmsPhotoGallery.films_photo_by_decade', ['decade' => $prevDecade]) }}"
                            style="padding: 5px 20px; border-bottom:1px solid blue;">
                            <i class="fa fa-backward"></i> পূর্ববর্তী দশক
                            </a>
                        @endif
                        @if($nextDecade)
                            <a href="{{ route('filmsPhotoGallery.films_photo_by_decade', ['decade' => $nextDecade]) }}"
                            style="padding: 5px 20px; border-bottom:1px solid blue;">
                            পরবর্তী দশক <i class="fa fa-forward"></i>
                            </a>
                        @endif
                    </div>

                    <!-- RIGHT: Tab Content for each Year -->
                    <div class="tab-content flex-grow-1 border ms-3 p-3" style="min-width: 400px; background-color: #fff; border-radius: 5px;">
                        @for($year = $startYear; $year <= $endYear; $year++)
                            <div class="tab-pane fade {{ $year === $startYear ? 'show active' : '' }}" id="v-pills-{{ $year }}" role="tabpanel" aria-labelledby="v-pills-{{ $year }}-tab">
                                <div class="row">
                                    @php
                                        $yearGalleries = $galleries->filter(function($item) use ($year) {
                                            return \Carbon\Carbon::parse($item->release_date)->year == $year;
                                        });
                                    @endphp
                                    @if($yearGalleries->isEmpty())
                                        <div class="col-12 text-center pt-5">
                                            <h4 style="font-family:SutonnyMJ; font-size:24px;">এই সালের কোনো ছবি পাওয়া যায়নি।</h4>
                                        </div>
                                    @else
                                        @foreach($yearGalleries as $gallery)
                                            <div class="col-md-4 mb-3 text-center">
                                                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->film_name }}" class="img-fluid" style="height:200px; width:100%; object-fit:cover; border:1px solid #ddd; margin-bottom:10px; border-radius: 8px;">
                                                <p style="font-family:SutonnyMJ; font-size:20px; font-weight:bold;">{{ $gallery->film_name }}</p>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection