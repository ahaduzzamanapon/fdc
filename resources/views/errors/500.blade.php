@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Error {{ __('messages.error') }} @parent
@stop

{{-- Page level styles --}}
@section('header_styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <style>
        .error-page {
            text-align: center;
            padding: 100px 20px;
            color: #333;
        }

        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #3819e7;
        }

        .error-message {
            font-size: 24px;
            margin-top: 20px;
        }

        .error-description {
            font-size: 16px;
            margin-top: 10px;
            color: #666;
        }

        .home-button {
            margin-top: 30px;
        }

        .home-button a {
            background-color: #3819e7;
            color: white;
            padding: 12px 25px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .home-button a:hover {
            background-color: #2c14c0;
        }
    </style>
@stop



{{-- Page content --}}
@section('content')
<script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.6.2/dist/dotlottie-wc.js" type="module"></script>

<section class="content error-page">
  <dotlottie-wc src="https://lottie.host/3794b84b-21be-4a8b-9b2e-7fc9e4621333/4AsxXbohEy.lottie" style="width: 300px;height: 300px" speed="1" autoplay loop></dotlottie-wc>
</section>
@stop
