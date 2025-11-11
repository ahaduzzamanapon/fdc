@extends('layouts.default')

{{-- Page title --}}
@section('title')
কাস্টম @parent
@stop

<style>
  .checkbox-wrapper-20 *,
    .checkbox-wrapper-20 *:after,
    .checkbox-wrapper-20 *:before {
    box-sizing: border-box;
  }
  .checkbox-wrapper-20 .checkbox-wrapper {
    width: 100%;
  }

  .checkbox-wrapper-20 .checkbox-input {
    clip: rect(0 0 0 0);
    -webkit-clip-path: inset(100%);
    clip-path: inset(100%);
    height: 1px;
    overflow: hidden;
    position: absolute;
    white-space: nowrap;
    width: 1px;
  }

  .checkbox-wrapper-20 .checkbox-input:checked + .checkbox-tile {
    border-color: #2260ff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    color: #2260ff;
  }

  .checkbox-wrapper-20 .checkbox-input:checked + .checkbox-tile .checkbox-icon,
    .checkbox-wrapper-20 .checkbox-input:checked + .checkbox-tile .checkbox-label {
    color: #2260ff;
  }

  .checkbox-wrapper-20 .checkbox-input:focus + .checkbox-tile {
    border-color: #2260ff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
  }

  .checkbox-wrapper-20 .checkbox-tile {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 7rem;
    min-height: 7rem;
    border-radius: 0.5rem;
    border: 2px solid #b5bfd9;
    background-color: #fff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    transition: 0.15s ease;
    cursor: pointer;
    position: relative;
    width: 100%;
  }

  .checkbox-wrapper-20 .checkbox-tile:hover {
    border-color: #2260ff;
  }

  .checkbox-wrapper-20 .checkbox-icon {
    transition: 0.375s ease;
    color: #494949;
  }

  .checkbox-wrapper-20 .checkbox-icon svg {
    width: 3rem;
    height: 3rem;
  }

  .checkbox-wrapper-20 .checkbox-label {
    color: #707070;
    transition: 0.375s ease;
    text-align: center;
  }

</style>

@section('content')
<!-- Content Header (Page header) -->
<!-- Main content -->
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card" width="88vw;">
            <section class="card-header">
                <h5 class="card-title d-inline">কাস্টম প্যাকেজ </h5>
            </section>

            @php
                $packages = \App\Models\Package::all();
            @endphp

            <div class="card-body">
                <!-- From Uiverse.io by Bodyhc -->
                <div class="row">
                    @foreach ($packages as $package)
                    <div class="col-md-4">
                        <div class="checkbox-wrapper-20">
                            <label class="checkbox-wrapper">
                                {{-- <input class="checkbox-input" type="radio" name="package_id" value="{{ $package->id }}"> --}}
                                <span class="checkbox-tile">
                                    <span class="checkbox-icon">
                                        <br>
                                        <svg viewBox="0 0 256 256" fill="currentColor" height="192" width="192"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect fill="none" height="256" width="256"></rect>
                                            <polygon stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                                stroke="currentColor" fill="none"
                                                points="72 40 184 40 240 104 128 224 16 104 72 40"></polygon>
                                            <polygon stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                                stroke="currentColor" fill="none"
                                                points="177.091 104 128 224 78.909 104 128 40 177.091 104"></polygon>
                                            <line stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                                stroke="currentColor" fill="none" y2="104" x2="240" y1="104" x1="16"></line>
                                        </svg>
                                    </span>
                                    <span>{{ $package->name }}</span>
                                    <span>Price : {{ $package->amount }}</span>
                                    <br>
                                    <a class="btn btn-primary" href="{{ route('makePayments.make_payment', $package->id) }}">বাছাই করুন</a>
                                    <br>
                                    <span>{{ $package->description }}</span>
                                    <br>
                                </span>
                            </label>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-md-4">
                        <div class="checkbox-wrapper-20">
                            <label class="checkbox-wrapper">
                                <span class="checkbox-tile">
                                    <span class="checkbox-icon">
                                        <br>
                                        <svg viewBox="0 0 256 256" fill="currentColor" height="192" width="192"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect fill="none" height="256" width="256"></rect>
                                            <polygon stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                                stroke="currentColor" fill="none"
                                                points="72 40 184 40 240 104 128 224 16 104 72 40"></polygon>
                                            <polygon stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                                stroke="currentColor" fill="none"
                                                points="177.091 104 128 224 78.909 104 128 40 177.091 104"></polygon>
                                            <line stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                                stroke="currentColor" fill="none" y2="104" x2="240" y1="104" x1="16"></line>
                                        </svg>
                                    </span>
                                    <span>কাস্টম প্যাকেজ</span>
                                    <br>
                                    <a class="btn btn-primary" href="{{ route('makePayments.makeCustomPayment') }}">তৈরি করুন</a>
                                    <br>
                                    <br>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


