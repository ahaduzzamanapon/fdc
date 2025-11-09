@extends('layouts.default')

{{-- Page title --}}
@section('title')
প্রামান্যচিত্র অ্যাপ্লিকেশন @parent
@stop

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('docufilm_applications.forward_details')
                </div>

                <div class="row">
                    <div class="row">
                        @include('docufilm_applications.forward_fields')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




