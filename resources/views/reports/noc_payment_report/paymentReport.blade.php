<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOC পেমেন্ট রিপোর্ট - BFDC</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .report-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        .header-logo {
            max-height: 70px;
        }
        .table-custom thead {
            background-color: #2c3e50;
            color: #ffffff;
        }
        .table-custom th {
            font-weight: 600;
            font-size: 13px;
        }
        .table-custom td {
            font-size: 13px;
            vertical-align: middle;
        }
        .badge-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        .badge-paid {
            background-color: #8dc542;
            color: white;
        }
        .badge-pending {
            background-color: #f39c12;
            color: white;
        }
        .badge-approved {
            background-color: #2563eb;
            color: white;
        }
        .badge-rejected {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>
<body>

    <div class="card report-card p-4">
        <!-- রিপোর্ট হেডার -->
        <div class="row align-items-center mb-4 border-bottom pb-3">
            <div class="col-sm-2 text-center text-sm-start mb-3 mb-sm-0">
                <img src="{{ asset('img/logo.png') }}" alt="BFDC Logo" class="header-logo img-fluid" onerror="this.style.display='none'">
            </div>
            <div class="col-sm-8 text-center">
                <h3 class="fw-bold mb-1" style="color: #2c3e50;">বাংলাদেশ চলচ্চিত্র উন্নয়ন কর্পোরেশন (বিএফডিসি)</h3>
                <h5 class="text-secondary mb-1">NOC ফি পেমেন্ট রিপোর্ট (NOC Payment Report)</h5>
                <p class="text-muted small mb-0">তৈরির তারিখ: {{ date('d M, Y h:i A') }}</p>
            </div>
            <div class="col-sm-2 text-center text-sm-end">
                <button onclick="window.print()" class="btn btn-outline-secondary btn-sm no-print">
                    <i class="fa-solid fa-print me-1"></i> প্রিন্ট
                </button>
            </div>
        </div>

        <!-- টেবিল -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-custom align-middle">
                <thead class="text-center align-middle">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>রেজিস্ট্রেশন টোকেন</th>
                        <th>ট্রানজেকশন আইডি</th>
                        <th>চলচ্চিত্র / কাজের নাম</th>
                        <th>প্রযোজক / প্রতিষ্ঠান</th>
                        <th>আবেদনকারীর নাম ও ফোন</th>
                        <th>পেমেন্টের পরিমাণ</th>
                        <th>তারিখ</th>
                        <th>স্ট্যাটাস</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalAmount = 0; @endphp
                    @forelse($nocPayments as $index => $row)
                        @php $totalAmount += (float) ($row->amount ?? 0); @endphp
                        <tr>
                            <td class="text-center fw-bold">{{ $index + 1 }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $row->token ?: 'N/A' }}</span></td>
                            <td class="fw-bold text-primary">{{ $row->trx_id ?: 'N/A' }}</td>
                            <td>{{ $row->name ?: 'N/A' }}</td>
                            <td>
                                <strong>{{ $row->producer ?: 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $row->organization }}</small>
                            </td>
                            <td>
                                {{ $row->full_name ?: 'N/A' }}<br>
                                <small class="text-muted"><i class="fa fa-phone"></i> {{ $row->mobile_no }}</small>
                            </td>
                            <td class="text-end fw-bold text-dark">
                                ৳ {{ number_format((float) ($row->amount ?? 0), 2) }}
                            </td>
                            <td class="text-center">
                                {{ $row->created_at ? $row->created_at->format('d M, Y') : 'N/A' }}
                            </td>
                            <td class="text-center">
                                @if(strtolower($row->status) === 'paid')
                                    <span class="badge-status badge-paid">পরিশোধিত</span>
                                @elseif(strtolower($row->status) === 'pending')
                                    <span class="badge-status badge-pending">অপেক্ষমাণ</span>
                                @elseif(strtolower($row->status) === 'approved')
                                    <span class="badge-status badge-approved">অনুমোদিত</span>
                                @else
                                    <span class="badge-status badge-rejected">{{ $row->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                <i class="fa-solid fa-circle-exclamation fa-2x mb-2 d-block"></i>
                                কোনো NOC পেমেন্ট তথ্য পাওয়া যায়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($nocPayments) > 0)
                <tfoot>
                    <tr class="table-light fw-bold">
                        <td colspan="6" class="text-end">সর্বমোট পেমেন্ট:</td>
                        <td class="text-end text-success">৳ {{ number_format($totalAmount, 2) }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

</body>
</html>
