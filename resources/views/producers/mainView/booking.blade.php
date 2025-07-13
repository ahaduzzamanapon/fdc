@extends('layouts.default')

{{-- Page title --}}
@section('title')
প্রোডাক্ট  বুকিং  @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>Producers</h1>
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
            <h5 class="card-title d-inline">প্রোডাক্ট  বুকিং </h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('producer.create_page') }}">প্রোডাক্ট  বুকিং করুন</a>
            </span>
        </section>
        <div class="card-body table-responsive" >
            <table class="table table-default">
                <thead>
                <tr>
                    <th>ক্রম</th>
                    <th>বুকিং আইডি</th>
                    <th>অবস্থা</th>
                    <th>প্রযোজক </th>
                    <th>সর্বমোট মূল্য</th>
                    <th>তৈরির তারিখ</th>
                    <th>অ্যাকশন</th>
                </tr>
                </thead>
                <tbody>
                @foreach($booking_requests as $key => $booking_request)
                <tr>
                    <td>{{  $key+1 }}</td>
                    <td>{{ $booking_request->book_id }}</td>
                    <td>{{ $booking_request->status }}</td>
                    <td>{{ $booking_request->producer_name }}</td>
                    <td>{{ $booking_request->total_price }}</td>
                    <td>{{ $booking_request->created_at }}</td>
                    <td>
                        <div class='btn-group'>
                        <a class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a class='btn btn-outline-primary btn-xs'><i
                            class="im im-icon-Pen"  data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                      
                    </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
