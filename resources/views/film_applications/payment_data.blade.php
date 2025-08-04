@extends('layouts.default')

{{-- Page title --}}
@section('title')
Film Applications @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>Film Applications</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>--}}
</section>

<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline">Film Applications</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" onclick="showMakePaymentModal({{ $filmApplication->id }})" href="javascript:void(0);">Make Payment</a>
            </span>
        </section>
        <div class="card-body table-responsive" >
            <div class="table-responsive">
                <table class="table table_data" id="filmApplications-table">
                    <thead>
                        <tr>
                            <th>SL</th>
                           
                            <th>Package Name</th>
                            <th>Amount</th>
                            <th>Transaction ID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($filmPackage as $key => $filmApplicationPayment)
                        <tr>
                            <td>{{ $key+1 }}</td>

                            <td>{{ $filmApplicationPayment->package_name }}</td>
                            <td>{{ $filmApplicationPayment->amount }}</td>
                            <td>{{ $filmApplicationPayment->trn_id }}</td>
                            <td>{{ $filmApplicationPayment->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          
        </div>
    </div>
</div>
@endsection
