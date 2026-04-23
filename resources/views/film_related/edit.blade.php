@extends('layouts.default')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1> চলচ্চিত্র সম্পর্কিত</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('adminlte-templates::common.errors')

        <div class="card">
            {!! Form::model($filmRelated, ['route' => ['film_related.update', $filmRelated->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    <!-- Title Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('title', ' শিরোনাম ') !!}
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Description Field -->
                    <div class="form-group col-sm-12 col-lg-12">
                        {!! Form::label('description', ' বর্ণনা ') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'editor', 'rows' => '4']) !!}
                    </div>

                    <div class="col-sm-12">
                        {!! Form::submit('সংরক্ষণ করুন', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('film_related.index') }}" class="btn btn-default"> বাতিল করুন </a>
                    </div>
                </div>
            </div>

            {{-- <div class="card-footer">
                {!! Form::submit('সংরক্ষণ করুন', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('film_related.index') }}" class="btn btn-default"> বাতিল করুন </a>
            </div> --}}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('script')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>
    <style>
        .ql-container {
            font-size: 14px;
            font-family: inherit;
        }
        .ql-editor {
            min-height: 200px;
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
    <script>
        setTimeout(function() {
            if (typeof Quill !== 'undefined') {
                const quill = new Quill('#editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            ['link'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['blockquote'],
                            ['clean']
                        ]
                    },
                    placeholder: 'বর্ণনা লিখুন...'
                });

                // Store content back to textarea on form submit
                document.querySelector('form').addEventListener('submit', function() {
                    document.getElementById('editor').value = quill.root.innerHTML;
                });
            }
        }, 500);
    </script>
@endsection
