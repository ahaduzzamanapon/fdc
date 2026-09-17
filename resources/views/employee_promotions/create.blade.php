@extends('layouts.default')

@section('title')
    নতুন ইনক্রিমেন্ট / পদোন্নতি যোগ করুন
@stop

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3><strong>নতুন ইনক্রিমেন্ট / পদোন্নতি তথ্য এন্ট্রি</strong></h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a class="btn btn-secondary" href="{{ route('employeePromotions.index') }}">
                        <i class="im im-icon-Arrow-Back"></i> তালিকায় ফিরে যান
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')
        @include('adminlte-templates::common.errors')

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                {!! Form::open(['route' => 'employeePromotions.store', 'method' => 'post']) !!}

                    @include('employee_promotions.fields')

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
