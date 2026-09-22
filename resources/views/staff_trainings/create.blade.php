@extends('layouts.default')

@section('title')
    নতুন ট্রেনিং যুক্ত করুন @parent
@stop

@section('content')
    @include('flash::message')

    <div class="card shadow-sm border-0 mb-4" style="min-height: auto !important; flex: none !important; margin: 0px !important;">
        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center" style="background-color: #8dc542 !important; color: #ffffff !important; border-top-left-radius: 4px; border-top-right-radius: 4px;">
            <h5 class="mb-0 font-weight-bold text-white"><i class="im im-icon-Add me-2"></i>নতুন প্রশিক্ষণ তথ্য যুক্ত করুন</h5>
            <a class="btn btn-sm font-weight-bold text-white shadow-sm" href="{{ route('staffTrainings.index') }}" style="background-color: #1f9303 !important; border: none;">
                <i class="im im-icon-Arrow-Back me-1"></i> তালিকায় ফিরে যান
            </a>
        </div>

        <div class="card-body p-4">
            {!! Form::open(['route' => 'staffTrainings.store', 'method' => 'post', 'files' => true]) !!}
                @include('staff_trainings.fields')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
