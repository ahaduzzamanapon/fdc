@extends('layouts.default')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1> যোগাযোগ</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('adminlte-templates::common.errors')

        <div class="card">
            {!! Form::open(['route' => 'contact_infos.store']) !!}

            <div class="card-body">
                <div class="row">
                    <!-- Title Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('title', 'শিরোনাম') !!}
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Description Field -->
                    <div class="form-group col-sm-12 col-lg-12">
                        {!! Form::label('description', 'বিবরণ:') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'editor', 'rows' => '4']) !!}
                    </div>

                    <div class="col-sm-12">
                        {!! Form::submit(' সংরক্ষণ ', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('contact_infos.index') }}" class="btn btn-default"> বাতিল করুন </a>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
@endsection
