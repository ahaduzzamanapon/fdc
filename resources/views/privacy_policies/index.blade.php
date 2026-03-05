@extends('layouts.default')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>গোপনীয়তার নীতিমালা</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('$route.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table" id="privacy_policies-table">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th colspan="3">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($privacy_policies as $privacyPolicy)
                            <tr>
                                <td>{{ $privacyPolicy->title }}</td>
                                <td>{!! substr($privacyPolicy->description, 0, 50) !!}...</td>
                                <td width="120">
                                    {!! Form::open(['route' => ['privacy_policies.destroy', $privacyPolicy->id], 'method' => 'delete']) !!}
                                    <div class='btn-group'>
                                        <a href="{{ route('privacy_policies.edit', [$privacyPolicy->id]) }}"
                                           class='btn btn-default btn-xs'>
                                            <i class="far fa-edit"></i>
                                        </a>
                                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection