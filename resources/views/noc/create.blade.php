@extends('welcome')

    <style>
        .form-header{
            width: 100%;
            display: flex;
            justify-content: space-between;
            background-color: #98dfe9;
            padding: 20px;
        }
        .form-header p{
            font-size: 18px !important;
            font-weight: bold;
            margin-bottom: 0px !important;
        }

    </style>
@section('body')
    <!-- card section -->
    <section class="cardSection" style="background-color: #eaf9fb; padding-bottom: 50px;">
        <div class="container">
            <div class="form-header">
                <p class="fleft">NOC আবেদন ফরম</p>
                <p class="fright"> NOC আবেদন তালিকা </p>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        {!! Form::open(['route' => 'noc.store','class' => 'form-horizontal col-md-12']) !!}
                        <div class="row">
                            @include('noc.fields')
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
