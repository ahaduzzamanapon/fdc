@extends('layouts.default')

{{-- Page title --}}
@section('title')
পার্টি অ্যাপ্লিকেশন @parent
@stop

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="card">

            <div class="card-body">
                <div style="justify-self: center;margin-bottom: 15px;padding: 0px 38px;cursor: pointer;">
                    <span class="text-center" style="font-weight: 650;font-size: 19px;">{{ 'নাগরিক রেজিস্ট্রেশন' }}</span>
                </div>

                <div class="row">

                    {!! Form::open(['route' => 'partyApplications.store', 'class' => 'form-horizontal col-md-12', 'enctype' => 'multipart/form-data']) !!}
                    <div class="row">
                        @include('party_applications.fields')
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
