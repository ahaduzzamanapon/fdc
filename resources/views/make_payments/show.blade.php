@extends('layouts.default')

{{-- Page title --}}
@section('title')
পেমেন্ট অ্যাপ্লিকেশন @parent
@stop

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('make_payments.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
