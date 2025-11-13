@extends('layouts.default')

{{-- Page title --}}
@section('title')
কাস্টম পেমেন্ট @parent
@stop

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('make_payments.forward_details')
                </div>

                <div class="row">
                    @include('make_payments.cp_forward_fields')
                </div>
            </div>
        </div>
    </div>
@endsection




