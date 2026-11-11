<table>
    <thead>
        <!-- এক্সেল টাইটেল -->
        <tr>
            <th colspan="8" style="font-weight: bold; font-size: 16px; text-align: center;">
                বাংলাদেশ চলচ্চিত্র উন্নয়ন কর্পোরেশন (বিএফডিসি)
            </th>
        </tr>
        <tr>
            <th colspan="8" style="font-weight: bold; font-size: 14px; text-align: center;">
                NOC পেমেন্ট রিপোর্ট (NOC Payment Report)
            </th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center; color: #555555;">
                তৈরির তারিখ: {{ date('d M, Y h:i A') }}
            </th>
        </tr>
        <tr><td colspan="8"></td></tr>

        <!-- টেবিল হেডার -->
        <tr style="background-color: #2c3e50; color: #ffffff; font-weight: bold;">
            <th style="font-weight: bold; text-align: center;">#</th>
            <th style="font-weight: bold;">টোকেন নম্বর</th>
            <th style="font-weight: bold;">ট্রানজেকশন আইডি</th>
            <th style="font-weight: bold;">চলচ্চিত্র / কাজের নাম</th>
            <th style="font-weight: bold;">প্রযোজক / প্রতিষ্ঠান</th>
            <th style="font-weight: bold;">আবেদনকারীর নাম ও মোবাইল</th>
            <th style="font-weight: bold; text-align: right;">পরিমাণ (BDT)</th>
            <th style="font-weight: bold; text-align: center;">তারিখ</th>
            <th style="font-weight: bold; text-align: center;">স্ট্যাটাস</th>
        </tr>
    </thead>
    <tbody>
        @php $totalAmount = 0; @endphp
        @forelse($nocPayments as $index => $row)
            @php $totalAmount += (float) ($row->amount ?? 0); @endphp
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $row->token ?? 'N/A' }}</td>
                <td>{{ $row->trx_id ?? 'N/A' }}</td>
                <td>{{ $row->name ?? 'N/A' }}</td>
                <td>{{ $row->producer ?? ($row->organization ?? 'N/A') }}</td>
                <td>{{ $row->full_name ?? 'N/A' }} ({{ $row->mobile_no ?? '' }})</td>
                <td style="text-align: right;">{{ number_format((float) ($row->amount ?? 0), 2) }}</td>
                <td style="text-align: center;">{{ $row->created_at ? $row->created_at->format('Y-m-d') : 'N/A' }}</td>
                <td style="text-align: center;">{{ $row->status ?? 'N/A' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" style="text-align: center;">কোনো NOC পেমেন্টের তথ্য পাওয়া যায়নি।</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="font-weight: bold; text-align: right;">সর্বমোট:</th>
            <th style="font-weight: bold; text-align: right;">{{ number_format($totalAmount, 2) }}</th>
            <th colspan="2"></th>
        </tr>
    </tfoot>
</table>
