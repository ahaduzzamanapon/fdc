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
                <h5 class="card-title d-inline">নোটিশ সমূহ</h5>
                <span class="float-right">
                    <a class="btn btn-primary pull-right" href="{{ route('notices.create') }}">নতুন যোগ করুন</a>
                </span>
            </section>

            <div class="card-body table-responsive">
                <table class="table table_data" id="notices-table">
                    <thead>
                        <tr>
                            <th>শিরোনাম</th>
                            <th>বর্ণনা</th>
                            <th> একশন </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notices as $notice)
                            <tr>
                                <td>{{ $notice->title }}</td>
                                <td>{!! Str::limit(strip_tags($notice->description), 50) !!}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            একশন </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('notices.edit', [$notice->id]) }}" class="dropdown-item">
                                                <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top"
                                                    title="সম্পাদনা করুন"></i> সম্পাদনা করুন
                                            </a>
                                            {!! Form::open(['route' => ['notices.destroy', $notice->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                            {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="মুছুন"></i> মুছুন', ['type' => 'submit', 'class' => 'dropdown-item', 'onclick' => "return confirm(' আপনি কি নিশ্চিত? ')"]) !!}
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
