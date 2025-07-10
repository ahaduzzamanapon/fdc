@extends('layouts.default')

{{-- Page title --}}
@section('title')
Leaves @parent
@stop

@section('content')
<!-- Content Header (Page header) -->


<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
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
            <div class="table-responsive">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">ড্রাফ্‌ট</a>
                      <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">অনুমোদন</a>
                      <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">বাতিল</a>
                    </div>
                </nav>
                <br>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        @include('leaves.leave_process.pending')
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">@include('leaves.leave_process.approved')</div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        @include('leaves.leave_process.rejected')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
