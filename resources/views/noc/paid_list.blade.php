@extends('layouts.default')

{{-- Page title --}}
@section('title')
NOC পেমেন্ট তালিকা
@stop

@section('content')
    <!-- Content Header (Page header) -->
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
            <section class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title d-inline m-0">NOC পরিশোধিত (পেমেন্ট) তালিকা</h5>
            </section>

            <div class="card-body table-responsive">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('messages.sl_label') }}</th>
                                <th>টোকেন নম্বর</th>
                                <th>ট্রানজ্যাকশন আইডি (TrxID)</th>
                                <th>চলচ্চিত্র / কাজের নাম</th>
                                <th>প্রযোজক / প্রতিষ্ঠান</th>
                                <th>আবেদনকারী</th>
                                <th>পরিমাণ</th>
                                <th>তারিখ</th>
                                <th>স্ট্যাটাস</th>
                                <th style="width: 220px;">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($nocs as $key => $noc)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td><span class="badge badge-light border">{{ $noc->token }}</span></td>
                                    <td class="font-weight-bold text-primary">{{ $noc->trx_id ?: 'N/A' }}</td>
                                    <td>{{ $noc->name }}</td>
                                    <td>{{ $noc->producer ?: ($noc->organization ?: 'N/A') }}</td>
                                    <td>
                                        {{ $noc->full_name }}<br>
                                        <small class="text-muted">{{ $noc->mobile_no }}</small>
                                    </td>
                                    <td class="font-weight-bold text-dark">৳ {{ number_format((float) ($noc->amount ?? 0), 2) }}</td>
                                    <td>{{ $noc->created_at ? $noc->created_at->format('d-m-Y') : 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-success px-2 py-1">পরিশোধিত</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1" style="gap: 6px;">
                                            <a target="_blank" href="{{ route('noc.download', $noc->token) }}" class="btn btn-sm btn-success" title="সার্টিফিকেট ডাউনলোড">
                                                <i class="im im-icon-Download"></i> ডাউনলোড
                                            </a>
                                            <form action="{{ route('nocPayments.pushAccounting', secure_hash_id($noc->id)) }}" method="POST" style="display:inline; margin: 0;" onsubmit="return confirm('আপনি কি এই NOC পেমেন্টটি BFDC Accounting-এ পুশ করতে চান?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary" title="অ্যাকাউন্টিংয়ে পুশ করুন">
                                                    <i class="im im-icon-Upload"></i> পুশ করুন
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">কোনো পরিশোধিত NOC পেমেন্ট পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
