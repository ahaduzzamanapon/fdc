@extends('layouts.default')

{{-- Page title --}}
@section('title')
NOC আবেদন @parent
@stop

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('noc.forward_details')
                </div>

                <div class="row">
                    <div class="row">
                        @include('noc.forward_fields')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection








