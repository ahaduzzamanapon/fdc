@extends('layouts.default')

{{-- Page title --}}
@section('title')
NOC তালিকা
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <div class="content">
        <div class="clearfix"></div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="clearfix"></div>
        <div class="card" width="88vw;">
            <section class="card-header">
                <h5 class="card-title d-inline">NOC আবেদন ফী তালিকা</h5>
            </section>

            <div class="card-body table-responsive">
                <div class="table-responsive">
                    <table class="table" id="">
                        <tr>
                            <th>{{ __('messages.sl_label') }}</th>
                            <th>পরিমাণ</th>
                            <th>চার্জ</th>
                            <th>মোট</th>
                            <th>একশন</th>
                        </tr>
                        @foreach ($noc as $key => $noc)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $noc->amount }}</td>
                                <td>{{ $noc->charge }}</td>
                                <td>{{ $noc->total }}</td>
                                <td>
                                    <a href="{{ route('noc.edit', secure_hash_id($noc->id)) }}" class="btn btn-sm btn-info"> Action </a>
                                    <form action="{{ route('nocPayments.pushAccounting', secure_hash_id($noc->id)) }}" method="POST" style="display:inline;" onsubmit="return confirm('আপনি কি এই NOC পেমেন্টটি BFDC Accounting-এ পুশ করতে চান?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary" title="অ্যাকাউন্টিংয়ে পুশ করুন">
                                            <i class="im im-icon-Upload"></i> পুশ করুন
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
