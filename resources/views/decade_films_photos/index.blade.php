@extends('layouts.default')

@section('title')
Photo Gallery @parent
@stop

@section('content')
<section class="content-header">
    <div class="card-breadcrumb">
        <h5><a href="{{ url('/dashboard') }}" style="text-decoration:none;color:black;">Dashboard</a> > Photo Gallery</h5>
    </div>
    <div class="separator-breadcrumb border-top"></div>
</section>

<div class="content">
    @include('flash::message')
    <div class="card">
        <section class="card-header">
            <h5 class="card-title d-inline">ফিল্ম স্থিরচিত্র তালিকা</h5>
            <span class="float-right">
                <a class="btn btn-primary" href="{{ route('decadeFilmsPhotos.create') }}">নতুন যোগ করুন</a>
            </span>
        </section>
        <div class="card-body">
            @include('decade_films_photos.table')
        </div>
    </div>
</div>
@endsection
