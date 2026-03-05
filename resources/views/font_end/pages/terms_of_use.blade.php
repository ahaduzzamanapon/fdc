@extends('welcome')
@section('title', 'ব্যবহারের শর্তাবলি')

@section('body')
<style>
    .footer-page-content .card {
        display: block !important;
        padding: 20px !important;
        align-items: flex-start !important;
        text-align: left !important;
    }

    .footer-page-content .card-body {
        padding: 0 !important;
        text-align: left !important;
    }

    .footer-page-content .card-title {
        text-align: left !important;
        margin-bottom: 0.5rem !important;
        width: 100% !important;
    }

    .footer-page-content .card-text {
        text-align: left !important;
        width: 100% !important;
    }

    .footer-page-content hr {
        margin: 10px 0 !important;
        width: 100% !important;
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
        <h2 style="font-family: 'SolaimanLipi', sans-serif">ব্যবহারের শর্তাবলি</h2>
        <div class="title-shape"></div>
    </div>

    <div class="mb-5 mt-2">
        @if($data->count() > 0)
            @foreach($data as $item)
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        @if($item->title)
                            <h4 class="card-title fw-bold text-left">{{ $item->title }}</h4>
                            <hr>
                        @endif
                        <div class="card-text pb-2 text-left">
                            {!! $item->description !!}
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info text-center">
                <p>No content available at the moment.</p>
            </div>
        @endif
    </div>
</div>
@stop