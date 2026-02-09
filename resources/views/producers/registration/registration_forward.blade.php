@extends('layouts.default')

{{-- Page title --}}
@section('title')
রেজিস্ট্রেশন অ্যাপ্লিকেশন @parent
@stop

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('producers.registration.forward_details')
                </div>

                <div class="row">
                    <div class="row">
                        @include('producers.registration.forward_fields')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




