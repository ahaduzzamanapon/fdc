@extends('layouts.print')

@section('title')
Payment Receipt @parent
@stop

@section('content')
<div style="width: 360px; margin: 0 auto; padding: 15px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 13px; color: #222; background: #fff; border: 1px solid #ddd; border-radius: 4px;">
    
    {{-- Header --}}
    <div style="text-align: center; margin-bottom: 12px; border-bottom: 2px dashed #8dc542; padding-bottom: 10px;">
        <h3 style="margin: 0; font-size: 18px; color: #1a4314;">বিএফডিসি পেমেন্ট মানি রিসিট</h3>
        <p style="margin: 2px 0 0 0; font-size: 11px; color: #666;">বাংলাদেশ চলচ্চিত্র উন্নয়ন কর্পোরেশন (BFDC)</p>
    </div>

    {{-- Details Table --}}
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 12px;">
        @if($filmApplication)
        <tr>
            <td style="padding: 4px 0; color: #555; width: 40%; vertical-align: top;">চলচ্চিত্র / কাজ:</td>
            <td style="padding: 4px 0; font-weight: 600; width: 60%;">{{ $filmApplication->film_title ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; color: #555; vertical-align: top;">প্রতিষ্ঠান:</td>
            <td style="padding: 4px 0; font-weight: 600;">{{ $filmApplication->organization_name ?? 'N/A' }}</td>
        </tr>
        @endif

        @if($filmPackage->type === 'booking')
        <tr>
            <td style="padding: 4px 0; color: #555; vertical-align: top;">বুকিং নং:</td>
            <td style="padding: 4px 0; font-weight: 600;">{{ $booking->book_id ?? ($filmPackage->name ?? 'N/A') }}</td>
        </tr>
        @if($booking && $booking->details && count($booking->details) > 0)
        <tr>
            <td style="padding: 4px 0; color: #555; vertical-align: top;">আইটেম:</td>
            <td style="padding: 4px 0; font-size: 11px;">
                @foreach($booking->details as $d)
                    <div>• {{ $d->item->name_bn ?? ($d->item->name_en ?? 'Item') }} ({{ $d->total_day ?? 1 }} দিন)</div>
                @endforeach
            </td>
        </tr>
        @endif
        @else
        <tr>
            <td style="padding: 4px 0; color: #555; vertical-align: top;">প্যাকেজের নাম:</td>
            <td style="padding: 4px 0; font-weight: 600;">{{ $filmPackage->package->name ?? ($filmPackage->name ?? 'N/A') }}</td>
        </tr>
        @endif

        <tr>
            <td colspan="2" style="border-top: 1px dashed #ccc; padding: 4px 0;"></td>
        </tr>

        <tr>
            <td style="padding: 4px 0; color: #555;">ইনভয়েস নং:</td>
            <td style="padding: 4px 0; font-family: monospace; font-size: 12px; font-weight: bold; color: #333;">{{ $filmPackage->trn_id ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; color: #555; vertical-align: top;">গেটওয়ে TrxID:</td>
            <td style="padding: 4px 0; font-family: monospace; font-size: 12px; font-weight: bold; color: #0d6efd; word-break: break-all;">
                {{ $filmPackage->TrxID ?: ($filmPackage->trn_id ?? 'N/A') }}
            </td>
        </tr>
        <tr>
            <td style="padding: 4px 0; color: #555;">মোট পরিমাণ:</td>
            <td style="padding: 4px 0; font-size: 14px; font-weight: bold; color: #198754;">{{ number_format($filmPackage->amount ?? 0, 2) }} BDT</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; color: #555;">পেমেন্ট অবস্থা:</td>
            <td style="padding: 4px 0;">
                <span style="background: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 3px; font-weight: bold; font-size: 11px;">
                    {{ strtoupper($filmPackage->status ?? 'SUCCESS') }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="padding: 4px 0; color: #555;">পরিশোধের সময়:</td>
            <td style="padding: 4px 0; font-size: 11px; color: #666;">
                {{ $filmPackage->paid_at ? date('d M, Y h:i A', strtotime($filmPackage->paid_at)) : ($filmPackage->updated_at ? $filmPackage->updated_at->format('d M, Y h:i A') : date('d M, Y h:i A')) }}
            </td>
        </tr>
    </table>

    {{-- Footer --}}
    <div style="border-top: 1px dashed #8dc542; padding-top: 8px; text-align: center; font-size: 11px; color: #666;">
        <p style="margin: 0;">ধন্যবাদ! আপনার পেমেন্ট সফলভাবে সম্পন্ন হয়েছে।</p>
        <p style="margin: 3px 0 0 0; font-size: 10px; color: #999;">প্রিন্টের সময়: {{ date('d M, Y h:i A') }}</p>
    </div>

    <div style="text-align: center; margin-top: 15px;">
        <button class="btn btn-success btn-sm" onclick="window.print()" style="padding: 6px 18px; font-size: 13px; border-radius: 4px; background-color: #8dc542; border-color: #8dc542; color: #fff; cursor: pointer;">Print Receipt</button>
    </div>
</div>
@endsection
