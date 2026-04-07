@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">বার্তার বিবরণ </h4>
                    </div>
                    <a href="{{ route('contact-messages.index') }}" class="btn btn-primary">তালিকায় ফিরে যান</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label><strong>নাম :</strong> {{ $message->name }} </label>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label><strong>ইমেইল :</strong> {{ $message->email }} </label>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label><strong>বার্তা :</strong></label>
                            <div class="p-3 border rounded bg-light">
                                {{ $message->message }}
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 text-muted">
                            <small>পাঠানোর তারিখ : {{ $message->created_at->format('d-m-Y') }}</small>
                        </div>
                    </div>

                    <hr>
                    {{-- <form action="{{ route('contact-messages.destroy', $message->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="im im-icon-Delete"></i> Delete Message
                        </button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
