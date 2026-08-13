<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Booking Invoice</title>
    <style>
        body {
            font-family: 'nikosh', sans-serif;
            font-size: 12px;
            color: #222;
        }

        /* ------------------ Header & Footer Styles ------------------ */
        @page {
            header: html_InvoiceHeader;
            footer: html_InvoiceFooter;
            margin-top: 130px;    /* হেডার স্পেস */
            margin-bottom: 90px;   /* ফুটার স্পেস */
            margin-left: 15mm;
            margin-right: 15mm;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #8dc542;
            padding-bottom: 10px;
        }

        .header-title {
            font-size: 20px;
            font-weight: bold;
            color: #1a4314;
            margin: 0;
        }

        .header-subtitle {
            font-size: 12px;
            color: #555;
            margin-top: 3px;
        }

        .footer-table {
            width: 100%;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            font-size: 10px;
            color: #666;
        }

        .signature-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .signature-box {
            border-top: 1px dashed #333;
            text-align: center;
            padding-top: 5px;
            width: 180px;
            font-weight: bold;
        }

        /* ------------------ Content Styles ------------------ */
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .invoice-title-badge {
            background-color: #8dc542;
            color: #ffffff;
            font-size: 14px;
            font-weight: bold;
            padding: 5px 15px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .table-info {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .table-info td {
            vertical-align: top;
        }

        .card-box {
            border: 1px solid #e0e0e0;
            padding: 10px;
            background-color: #fcfcfc;
            border-radius: 4px;
        }

        .card-header {
            font-weight: bold;
            border-bottom: 1px solid #8dc542;
            padding-bottom: 4px;
            margin-bottom: 8px;
            color: #2c3e50;
            font-size: 13px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .invoice-table th {
            background-color: #2c3e50;
            color: #ffffff;
            border: 1px solid #1a252f;
            padding: 7px;
            text-align: left;
            font-size: 11px;
        }

        .invoice-table td {
            border: 1px solid #ddd;
            padding: 7px;
            font-size: 11px;
        }

        .badge-status {
            background-color: #8dc542;
            color: #ffffff;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <!-- ==================== MPDF HEADER ==================== -->
    <htmlpageheader name="InvoiceHeader">
        <table class="header-table">
            <tr>
                <td width="15%">
                    <!-- প্রজেক্টের লোগো পাথ দিন (e.g. public/images/logo.png) -->
                    <img src="{{ public_path('images/logo.png') }}" style="height: 60px;" alt="Logo">
                </td>
                <td width="85%" class="text-right">
                    <h1 class="header-title">বাংলাদেশ চলচ্চিত্র উন্নয়ন কর্পোরেশন (বিএফডিসি)</h1>
                    <div class="header-subtitle">কবীরপুর, সাভার, ঢাকা-১৩৪৪ | ফোন: +৮৮-০২-XXXXXXX</div>
                    <div class="header-subtitle">ইমেইল: info@fdc.gov.bd | ওয়েব: www.fdc.gov.bd</div>
                </td>
            </tr>
        </table>
    </htmlpageheader>

    <!-- ==================== MPDF FOOTER ==================== -->
    <htmlpagefooter name="InvoiceFooter">
        <!-- স্বাক্ষর অংশ -->
        <table class="signature-table">
            <tr>
                <td width="50%">
                    <div class="signature-box">প্রস্তুতকারীর স্বাক্ষর</div>
                </td>
                <td width="50%" class="text-right">
                    <div class="signature-box" style="margin-left: auto;">অনুমোদনকারীর স্বাক্ষর</div>
                </td>
            </tr>
        </table>

        <!-- ফুটার বার -->
        <table class="footer-table">
            <tr>
                <td width="50%">
                    প্রিন্টের তারিখ: {{ date('d M, Y h:i A') }}
                </td>
                <td width="50%" class="text-right">
                    পৃষ্ঠা {PAGENO} / {nbpg}
                </td>
            </tr>
        </table>
    </htmlpagefooter>

    <!-- ==================== MAIN CONTENT ==================== -->
    <div class="text-center">
        <span class="invoice-title-badge">{{ __('messages.booking_details') }}</span>
    </div>

    <!-- বুকিং ও প্রডিউসার সংক্রান্ত তথ্য -->
    <table class="table-info">
        <tr>
            <td width="49%">
                <div class="card-box">
                    <div class="card-header">{{ __('messages.booking_information') }}</div>
                    <p><strong>{{ __('messages.status_label') }}:</strong> <span class="badge-status">{{ $booking->status ?? 'N/A' }}</span></p>
                    <p><strong>বুকিং আইডি:</strong> {{ $booking->name ?? 'N/A' }}</p>
                    <p><strong>{{ __('messages.total_price') }}:</strong> {{ number_format($booking->amount ?? 0, 2) }} BDT</p>
                    <p><strong>{{ __('messages.created_at') }}:</strong> {{ $booking->created_at ? $booking->created_at->format('M d, Y H:i A') : 'N/A' }}</p>
                </div>
            </td>
            <td width="2%"></td> <!-- স্পেস -->
            <td width="49%">
                <div class="card-box">
                    <div class="card-header">{{ __('messages.associated_details') }}</div>
                    <p><strong>{{ __('messages.producer') }}:</strong> {{ $items?->producer?->organization_name ?? 'N/A' }}</p>
                    <p><strong>{{ __('messages.film_label') }}:</strong> {{ $items?->film?->film_title ?? 'N/A' }}</p>
                </div>
            </td>
        </tr>
    </table>

    <h3 style="margin-top: 15px; margin-bottom: 5px; color: #2c3e50;">{{ __('messages.booked_items_details') }}</h3>

    <!-- বুকিং আইটেমের তালিকা -->
    <table class="invoice-table">
        <thead>
            <tr>
                <th>#</th>
                {{-- <th>{{ __('messages.category') }}</th> --}}
                <th>আইটেম নাম</th>
                <th>আইটেম মূল্য</th>
                <th>রেকুয়েস্ট দিন</th>
                <th>রেকুয়েস্ট অ্যামাউন্ট</th>
                <th>{{ __('messages.total_days') }}</th>
                <th class="text-right">{{ __('messages.amount') }}</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($items->details) && count($items->details) > 0)
                @foreach($items->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    {{-- <td>{{ $detail->category ?? 'N/A' }}</td> --}}
                    <td>{{ $detail->item->name_bn ?? 'N/A' }}</td>
                    <td>{{ $detail->item_amt ?? 'N/A' }}</td>
                    <td>{{ $detail->request_days ?? 'N/A' }}</td>
                    <td>{{ $detail->request_total_amt ?? 'N/A' }}</td>
                    <td>{{ $detail->app_days ?? 0 }}</td>
                    <td class="text-right">{{ number_format($detail->app_total_amt ?? 0, 2) }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">{{ __('messages.no_booking_details_found') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

</body>
</html>
