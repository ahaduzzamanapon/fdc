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
                <h5 class="card-title d-inline">গোপনীয়তার নীতিমালা</h5>
                <span class="float-right">
                    <a class="btn btn-primary pull-right" href="{{ route('privacy_policies.create') }}">Add New</a>
                </span>
            </section>

            <div class="card-body table-responsive">
                <table class="table table_data" id="privacy_policies-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($privacy_policies as $privacyPolicy)
                            <tr>
                                <td>{{ $privacyPolicy->title }}</td>
                                <td>{!! Str::limit(strip_tags($privacyPolicy->description), 50) !!}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Actions </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('privacy_policies.edit', [$privacyPolicy->id]) }}"
                                                class="dropdown-item">
                                                <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top"
                                                    title="Edit"></i> Edit
                                            </a>
                                            {!! Form::open(['route' => ['privacy_policies.destroy', $privacyPolicy->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                            {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="Delete"></i> Delete', ['type' => 'submit', 'class' => 'dropdown-item', 'onclick' => "return confirm('Are you sure?')"]) !!}
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