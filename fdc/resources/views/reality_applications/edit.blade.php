@extends('layouts.default')

{{-- Page title --}}
@section('title')
রিয়েলিটি শো অ্যাপ্লিকেশন @parent
@stop

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="card">
           <div class="card-body">
                <div class="row">
                    {!! Form::model($filmApplication, ['route' => ['realityApplications.update', $filmApplication->id], 'method' => 'patch','class' => 'form-horizontal col-md-12']) !!}
                        <div class="row">
                            @include('reality_applications.fields')
                        </div>
                    {!! Form::close() !!}
                </div>
           </div>
       </div>
   </div>
@endsection
