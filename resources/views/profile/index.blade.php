@extends('layouts.default')
@section('title')
Profile @parent
@stop
@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <div aria-label="breadcrumb" class="card-breadcrumb">
            <h5><a href="{{ url('/dashboard') }}"  style="text-decoration: none; color: black;">Dashboard</a> > Profile </h5>
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
                            <h3 class="card-title mb-0">User Profile</h3>
                        </div>
                        <div class="card-body" >
                            <div class="row">
                                <!-- Profile Image Section -->
                                <div class="col-md-4 text-center mb-4 mb-md-0">
                                    <img src="{{ asset('/').Auth::user()->picture }}"
                                        alt="User Image"
                                        class="rounded-circle img-thumbnail shadow-sm"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                    <h4 class="mt-3 mb-1 font-weight-bold">{{ Auth::user()->name_bn }}</h4>
                                    <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                </div>

                                <!-- Profile Details Section -->
                                <div class="col-md-8">
                                    <table class="table table-bordered table-striped table-hover">
                                        <tbody>
                                            <tr>
                                                <th scope="row"><i class="fas fa-user mr-1 text-primary"></i> Name</th>
                                                <td>{{ Auth::user()->name_bn }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><i class="fas fa-envelope mr-1 text-primary"></i> Email</th>
                                                <td>{{ Auth::user()->email }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><i class="fas fa-phone-alt mr-1 text-primary"></i> Phone</th>
                                                <td>{{ Auth::user()->mobile_no }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><i class="fas fa-clock mr-1 text-primary"></i> Member Since</th>
                                                <td>{{ Auth::user()->created_at->format('d M, Y') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a href="{{ route('profile.edit' ,Auth::id() ) }}" class="btn btn-outline-info mt-3 float-right">
                                        <i class="fas fa-edit"></i> Edit Profile
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
