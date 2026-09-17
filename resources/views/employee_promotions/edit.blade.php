@extends('layouts.default')

@section('title')
    ইনক্রিমেন্ট / পদোন্নতি তথ্য এডিট
@stop

@section('content')
    @include('flash::message')
    @include('adminlte-templates::common.errors')

    <div class="card shadow-sm border-0 mb-4" style="min-height: auto !important; flex: none !important;">
        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center" style="background-color: #8dc542 !important; color: #ffffff !important; border-top-left-radius: 4px; border-top-right-radius: 4px;">
            <h5 class="mb-0 font-weight-bold text-white"><i class="im im-icon-Pen me-2"></i>ইনক্রিমেন্ট / পদোন্নতি তথ্য সংশোধন</h5>
            <a class="btn btn-sm font-weight-bold shadow-sm" href="{{ route('employeePromotions.index') }}" style="background-color: #1f9303 !important; color: #ffffff !important; border: none;">
                <i class="im im-icon-Arrow-Back me-1"></i> তালিকায় ফিরে যান
            </a>
        </div>

        <div class="card-body p-4">
            {!! Form::model($promotion, ['route' => ['employeePromotions.update', $promotion->id], 'method' => 'patch']) !!}

                @include('employee_promotions.fields')

            {!! Form::close() !!}
        </div>
    </div>
@endsection
