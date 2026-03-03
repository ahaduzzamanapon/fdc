@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">বার্তার বিবরণ (Message Details)</h4>
                    </div>
                    <a href="{{ route('contact-messages.index') }}" class="btn btn-primary">Back to List</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label><strong>নাম (Name):</strong></label>
                            <p>{{ $message->name }}</p>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label><strong>ইমেইল (Email):</strong></label>
                            <p>{{ $message->email }}</p>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label><strong>বার্তা (Message):</strong></label>
                            <div class="p-3 border rounded bg-light">
                                {{ $message->message }}
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 text-muted">
                            <small>পাঠানোর সময় (Sent At): {{ $message->created_at->format('d-m-Y H:i A') }}</small>
                        </div>
                    </div>

                    <hr>
                    <form action="{{ route('contact-messages.destroy', $message->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="im im-icon-Delete"></i> Delete Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection