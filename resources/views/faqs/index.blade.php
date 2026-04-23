@extends('layouts.default')

@section('content')
    <section class="content-header">
    </section>

    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>

        <div class="card">
            <section class="card-header">
                <h5 class="card-title d-inline">সচরাচর জিজ্ঞাসা</h5>
                <span class="float-right">
                    <a class="btn btn-primary pull-right" href="{{ route('faqs.create') }}"> নতুন যোগ করুন </a>
                </span>
            </section>

            <div class="card-body table-responsive">
                <table class="table table_data" id="faqs-table">
                    <thead>
                        <tr>
                            <th>প্রশ্ন</th>
                            <th>উত্তর</th>
                            <th>কর্ম</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $faq)
                            <tr>
                                <td>{{ $faq->title }}</td>
                                <td>{!! Str::limit(strip_tags($faq->description), 50) !!}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            কর্ম </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('faqs.edit', [$faq->id]) }}" class="dropdown-item">
                                                <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top"
                                                    title="সম্পাদনা"></i> সম্পাদনা
                                            </a>
                                            {!! Form::open(['route' => ['faqs.destroy', $faq->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                            {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="মুছুন"></i> মুছুন', ['type' => 'submit', 'class' => 'dropdown-item', 'onclick' => "return confirm('আপনি কি নিশ্চিত?')"]) !!}
                                            {!! Form::close() !!}
                                        </div>
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
