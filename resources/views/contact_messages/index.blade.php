@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">যোগাযোগের বার্তা </h4>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mt-4 table_data" id="contact-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>নাম </th>
                                    <th>ইমেইল </th>
                                    <th>বার্তা </th>
                                    <th>তারিখ </th>
                                    <th>অ্যাকশন </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($messages as $message)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $message->name }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td>{{ Str::limit($message->message, 50) }}</td>
                                        <td>{{ $message->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('contact-messages.show', $message->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="im im-icon-Eye"></i> দেখুন
                                                </a>
                                                <form action="{{ route('contact-messages.destroy', $message->id) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger ms-2">
                                                        <i class="im im-icon-Delete"></i> মুছে ফেলুন
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script>
        $(document).ready(function () {
            $('#contact-table').DataTable();
        });
    </script>
@endsection
