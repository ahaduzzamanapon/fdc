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
                <p class="fright"> NOC আবেদন তালিকা </p>
                <p class="fleft">NOC আবেদন ফরম</p>
            </div>

            <div class="card-body" style="background: #fff;">
                <div style="padding: 15px;">
                    @include('noc.show_details')
                </div>
            </div>

        </div>
    </section>

@stop
