@extends('layouts.default')
@section('title')
Profile {{ __('messages.profile') }} @parent
@stop
@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <div aria-label="breadcrumb" class="card-breadcrumb">
            <h5><a href="{{ url('/dashboard') }}"  style="text-decoration: none; color: black;">{{ __('messages.dashboard') }}</a> > {{ __('messages.profile') }} </h5>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </section>
    <div class="clearfix"></div>
    @include('flash::message')
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 2000);
    </script>


    <section class="content">
        <div class="container-fluid" >
            <div class="row justify-content-center" >
                <div class="col-lg-12" >
                    <div class="card shadow-lg border-0 rounded-lg" >
                        <div class="card-header text-white d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">{{ __('messages.user_profile') }}</h3>
                        </div>
                        <div class="card-body" >
                            <div class="row">
                                <!-- Profile Image Section -->

                                <!-- Profile Details Section -->
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped table-hover">
                                        <tbody>
                                            <tr>
                                                <th scope="row"><i class="fas fa-phone-alt mr-1 text-primary"></i> {{ __('messages.phone') }}</th>
                                                <td>{{ Auth::guard('producer')->user()->phone_number }}</td>
                                                <th scope="row"><i class="fas fa-clock mr-1 text-primary"></i> {{ __('messages.joining_date') }}</th>
                                                <td>{{ Auth::guard('producer')->user()->created_at->format('d M, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><i class="fas fa-clock mr-1 text-primary"></i> {{ __('messages.organization_name') }}</th>
                                                <td>{{ Auth::guard('producer')->user()->organization_name }}</td>
                                                <th scope="row"><i class="fas fa-clock mr-1 text-primary"></i> {{ __('messages.owners_name') }}</th>
                                                <td>{{ Auth::guard('producer')->user()->owners_name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><i class="fas fa-clock mr-1 text-primary"></i> {{ __('messages.nid') }}</th>
                                                <td>{{ Auth::guard('producer')->user()->owners_nid }}</td>
                                                <th scope="row"><i class="fas fa-clock mr-1 text-primary"></i> {{ __('messages.bank_name') }}</th>
                                                <td>{{ Auth::guard('producer')->user()->bank_account_number }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><i class="fas fa-clock mr-1 text-primary"></i> {{ __('messages.type') }}</th>
                                                <td>{{ Auth::guard('producer')->user()->types }}</td>
                                                <th scope="row"><i class="fas fa-clock mr-1 text-primary"></i> {{ __('messages.nominee_name') }}</th>
                                                <td>{{ Auth::guard('producer')->user()->nominee_name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a href="{{ route('producers.edit' , Auth::guard('producer')->user()->id ) }}" class="btn btn-outline-info mt-3 float-right">
                                        <i class="fas fa-edit"></i> {{ __('messages.edit_profile') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
