@extends('welcome')
@section('title', 'যোগাযোগ')

@section('body')
<style>
    .footer-page-content .card {
        display: block !important;
        padding: 24px !important;
        align-items: flex-start !important;
        text-align: left !important;
        border-radius: 8px !important;
    }

    .footer-page-content .card-body {
        padding: 0 !important;
        text-align: left !important;
    }

    .footer-page-content .card-title {
        text-align: center !important;
        margin-bottom: 0.5rem !important;
        width: 100% !important;
    }

    .footer-page-content .card-text {
        text-align: left !important;
        width: 100% !important;
    }

    .footer-page-content hr {
        margin: 15px 0 20px 0 !important;
        width: 100% !important;
        opacity: 0.15;
    }

    .footer-page-content .section-title {
        text-align: left !important;
    }

    .footer-page-content .title-shape {
        margin-left: 0 !important;
        margin-right: auto !important;
    }
</style>

<div class="container footer-page-content py-4">
    <div class="section-title p-3 mt-3">
        <h2 style="font-family: 'SolaimanLipi', sans-serif">যোগাযোগ</h2>
        <div class="title-shape"></div>
    </div>

    <div class="mb-5 mt-2">
        @if($data->count() > 0)
            @foreach($data as $item)
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <!-- BFDC Logo -->
                        <div class="text-center mb-3 pt-2">
                            @php
                                $siteSetting = \App\Models\SiteSetting::first();
                            @endphp
                            @if(isset($siteSetting) && !empty($siteSetting->logo))
                                <img src="{{ \Illuminate\Support\Str::startsWith($siteSetting->logo, 'http') ? $siteSetting->logo : asset($siteSetting->logo) }}" alt="BFDC Logo" style="max-height: 75px;">
                            @else
                                <img src="{{ asset('images/logo.svg') }}" alt="BFDC Logo" style="max-height: 75px;">
                            @endif
                        </div>

                        <div class="card-text pb-2 mt-3">
                            @php
                                $rawLines = explode("\n", str_replace(["\r", "\t"], "", strip_tags($item->description)));
                                $cleanLines = array_filter(array_map('trim', $rawLines));
                            @endphp
                            @if(count($cleanLines) > 0)
                                <div class="contact-list mt-3" style="font-family: 'SolaimanLipi', sans-serif;">
                                    @foreach($cleanLines as $idx => $line)
                                        @php
                                            $lower = mb_strtolower($line);
                                            if (Str::contains($lower, ['ইমেইল', 'email', 'mail']) || $idx === 0) {
                                                $iconClass = 'fas fa-envelope';
                                            } elseif (Str::contains($lower, ['ফোন', 'phone', 'অফিস', 'tel']) || $idx === 1) {
                                                $iconClass = 'fas fa-phone';
                                            } elseif (Str::contains($lower, ['মোবাইল', 'mobile', 'cell']) || $idx === 2) {
                                                $iconClass = 'fas fa-mobile-alt';
                                            } else {
                                                $iconClass = 'fas fa-info-circle';
                                            }
                                        @endphp
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3 mr-3 text-center" style="width: 38px; height: 38px; background-color: #eef2ff; color: #0d6efd; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                <i class="{{ $iconClass }}" style="font-size: 16px;"></i>
                                            </div>
                                            <div style="font-size: 17px; font-weight: 500; color: #333;">
                                                {{ $line }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div style="font-size: 16px; line-height: 1.8;">
                                    {!! $item->description !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info text-center">
                <p>কোনো তথ্য পাওয়া যায়নি।</p>
            </div>
        @endif
    </div>
</div>
@stop