@extends('layouts.default')

{{-- Page title --}}
@section('title')
বুকিং অ্যাপ্লিকেশন @parent
@stop

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('producers.mainView.forward_details')
                </div>

                <div class="row">
                    <div class="row">
                        @include('producers.mainView.forward_fields')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




