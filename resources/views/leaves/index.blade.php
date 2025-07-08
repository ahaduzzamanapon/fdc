@extends('layouts.default')

{{-- Page title --}}
@section('title')
Leaves @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content mb-5 mt-5" >
    <div class="row">
        @foreach($total_leaves as $key => $leave)
            <div class="col-md-3 text-center">
                <div class='border p-3' style="background:{{ $key == 0 ? '#42aec58a' : '#8dc54263'}};border-radius: 8px">
                    <h5 style='line-height: 44px;' class="font-weight-bold">{{ $leave->name_en == 'cl' ? "ক্যাসুয়াল ছুটি" : "অসুস্থতা ছুটি" }}</h5>
                    <h6>{{ 'মোটঃ '. $leave->day }}</h6>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>
    {{-- @dd($total_leaves); --}}
    @include('flash::message')
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 2000);
    </script>

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline">ছুটির তালিকা</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('leaves.create') }}">নতুন যোগ করুন</a>
            </span>
        </section>
        <div class="card-body table-responsive">
            @include('leaves.table')
        </div>
    </div>
</div>
@endsection
