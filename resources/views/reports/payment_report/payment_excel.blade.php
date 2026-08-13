<table>
    <thead>
        <!-- এক্সেল টাইটেল -->
        <tr>
            <th colspan="7" style="font-weight: bold; font-size: 16px; text-align: center;">
                বাংলাদেশ চলচ্চিত্র উন্নয়ন কর্পোরেশন (বিএফডিসি)
            </th>
        </tr>
        <tr>
            <th colspan="7" style="font-weight: bold; font-size: 14px; text-align: center;">
                পেমেন্ট রিপোর্ট (Payment Report)
            </th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center; color: #555555;">
                তৈরির তারিখ: {{ date('d M, Y h:i A') }}
            </th>
        </tr>
        <tr><td colspan="7"></td></tr> {{-- ফাঁকা রো --}}

        <!-- টেবিল হেডার -->
        <tr style="background-color: #2c3e50; color: #ffffff; font-weight: bold;">
            <th style="font-weight: bold; text-align: center;">#</th>
            <th style="font-weight: bold;">পেমেন্ট টাইপ</th>
            <th style="font-weight: bold;">পেমেন্ট টাইটেল</th>
            <th style="font-weight: bold;">ট্রানজেকশন আইডি</th>
            <th style="font-weight: bold; text-align: right;">এমাউন্ট</th>
            <th style="font-weight: bold; text-align: center;">তারিখ</th>
            <th style="font-weight: bold; text-align: center;">স্ট্যাটাস</th>
        </tr>
    </thead>
    <tbody>
        @php $totalAmount = 0; @endphp
        @forelse($payments as $index => $row)
            @php $totalAmount += (float) ($row->amount ?? $row['amount'] ?? 0); @endphp
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-transform: capitalize;">{{ $row->type ?? $row['type'] ?? 'N/A' }}</td>
                <td>{{ $row->name ?? $row['name'] ?? 'N/A' }}</td>
                <td>{{ $row->trn_id ?? $row['trn_id'] ?? 'N/A' }}</td>
                <td style="text-align: right;">{{ number_format($row->amount ?? $row['amount'] ?? 0, 2) }}</td>
                <td style="text-align: center;">{{ $row->paid_at ?? $row['paid_at'] ?? 'N/A' }}</td>
                <td style="text-align: center;">{{ $row->status ?? $row['status'] ?? 'N/A' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center;">কোনো পেমেন্টের তথ্য পাওয়া যায়নি।</td>
            </tr>
        @endforelse
    </tbody>
    @if(count($payments) > 0)
    <tfoot>
        <tr style="font-weight: bold; background-color: #f2f2f2;">
            <td colspan="4" style="text-align: right; font-weight: bold;">সর্বমোট (Total):</td>
            <td style="text-align: right; font-weight: bold; color: #1a4314;">{{ number_format($totalAmount, 2) }}</td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
    @endif
</table>
