@extends('layouts.default')

{{-- Page title --}}
@section('title')
NOC আবেদন @parent
@stop

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    {!! Form::open(['route' => ['noc.update', $noc->id], 'class' => 'form-horizontal col-md-12', 'method' => 'PUT']) !!}
                        <input type="hidden" name="noc_id" value="{{ $noc->id }}">
                        <div class="row">
                            <div class="col-3">
                                <label>Amount</label>
                                <input type="number" name="amount" value="{{ $noc->amount }}">
                            </div>

                            <div class="col-3">
                                <label>Charge</label>
                                <input type="number" name="charge" value="{{ $noc->charge }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-3">
                                <a href="{{ route('noc.index') }}" class="btn btn-danger">Cancel</a>
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection








