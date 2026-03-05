@extends('layouts.default')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ব্যবহারের শর্তাবলি</h1>
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
                    <table class="table" id="terms_of_uses-table">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th colspan="3">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($terms_of_uses as $termsOfUse)
                            <tr>
                                <td>{{ $termsOfUse->title }}</td>
                                <td>{!! substr($termsOfUse->description, 0, 50) !!}...</td>
                                <td width="120">
                                    {!! Form::open(['route' => ['terms_of_uses.destroy', $termsOfUse->id], 'method' => 'delete']) !!}
                                    <div class='btn-group'>
                                        <a href="{{ route('terms_of_uses.edit', [$termsOfUse->id]) }}"
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