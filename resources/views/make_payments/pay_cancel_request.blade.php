@extends('layouts.default')

{{-- Page title --}}
@section('title')
পেমেন্ট @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline"> পেমেন্ট বাতিল ফরম </h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('makePayments.index') }}" > পেমেন্ট তালিকা </a>
            </span>
        </section>
        <div class="card-body">
            <div class="table-responsive">
                @if($payment)
                    <p> পেমেন্ট বাতিল করলে সিস্টেম কোস্ট এর জন্য <b>অতিরিক্ত ১০% চার্জ</b> প্রযোজ্য । </p>
                    <p>আপনি কি নিশ্চিত যে আপনি <strong>{{ $payment->amount }} টাকা</strong> পেমেন্ট বাতিল করতে চান? </p>
                    <form action="{{ route('pay.cancel.confirm', Crypt::encrypt($payment->id)) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('আপনি বাতিল করতে চান ?')">হ্যাঁ, পেমেন্ট বাতিল করুন</button>
                        <a href="{{ route('makePayments.index') }}" class="btn btn-secondary">না, ফিরে যান</a>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
    <script>

    </script>
@endsection
