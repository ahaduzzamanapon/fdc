<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পেমেন্ট রিপোর্ট - BFDC</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
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
            font-size: 14px;
        }
        .badge-status {
            background-color: #8dc542;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        /* প্রিন্ট করার সময় বাটন এবং অপ্রয়োজনীয় এলিমেন্ট হাইড করার জন্য */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #fff;
            }
            .report-card {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>

    <div class="container my-4">
        <!-- নেভিগেশন ও প্রিন্ট বাটন (No Print Area) -->
        {{-- <div class="d-flex justify-content-between align-items-center mb-3 no-print">
            <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> ফিরে যান
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-print me-1"></i> প্রিন্ট করুন
            </button>
        </div> --}}

        <div class="card report-card p-4">
            <!-- ১. প্রাতিষ্ঠানিক হেডার -->
            <div class="row align-items-center border-bottom pb-3 mb-4">
                <div class="col-md-2 text-center text-md-start mb-2 mb-md-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="header-logo img-fluid">
                </div>
                <div class="col-md-10 text-center text-md-end">
                    <h3 class="fw-bold text-success mb-1">বাংলাদেশ চলচ্চিত্র উন্নয়ন কর্পোরেশন (বিএফডিসি)</h3>
                    <p class="text-muted mb-0 small">কবীরপুর, সাভার, ঢাকা-১৩৪৪ | ইমেইল: info@fdc.gov.bd</p>
                    <p class="text-muted mb-0 small">ওয়েব: www.fdc.gov.bd | ফোন: +৮৮-০২-XXXXXXX</p>
                </div>
            </div>

            <!-- ২. রিপোর্টের মূল টাইটেল ও ফিল্টার সামারি -->
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <div>
                    <h4 class="mb-1 fw-bold text-dark">
                        <i class="fa-solid fa-file-invoice-dollar text-success me-2"></i>পেমেন্ট রিপোর্ট
                    </h4>
                    <span class="text-muted small">তৈরির তারিখ: {{ date('d M, Y h:i A') }}</span>
                </div>
                <div class="mt-2 mt-md-0">
                    <span class="badge bg-light text-dark border p-2 me-2">
                        <strong>মোট রেকর্ড:</strong> {{ count($payments) }} টি
                    </span>
                </div>
            </div>

            <!-- ৩. পেমেন্ট ডাটা টেবিল -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-custom align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th width="12%">পেমেন্ট টাইপ</th>
                            <th width="25%">পেমেন্ট টাইটেল</th>
                            <th width="18%">ট্রানজেকশন আইডি</th>
                            <th class="text-end" width="15%">এমাউন্ট</th>
                            <th class="text-center" width="13%">তারিখ</th>
                            <th class="text-center" width="12%">স্ট্যাটাস</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalAmount = 0; @endphp
                        @forelse($payments as $index => $row)
                            @php $totalAmount += (float) ($row['amount'] ?? 0); @endphp
                            <tr>
                                <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <span class="text-capitalize fw-semibold">{{ $row['type'] ?? 'N/A' }}</span>
                                </td>
                                <td class="fw-medium">{{ $row['name'] ?? 'N/A' }}</td>
                                <td><code>{{ $row['trn_id'] ?? 'N/A' }}</code></td>
                                <td class="text-end fw-bold text-dark">
                                    {{ number_format($row['amount'] ?? 0, 2) }} ৳
                                </td>
                                <td class="text-center small">{{ $row['paid_at'] ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <span class="badge badge-status">{{ $row['status'] ?? 'N/A' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                                    কোনো পেমেন্টের তথ্য পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <!-- সর্বমোট টাকা -->
                    @if(count($payments) > 0)
                    <tfoot>
                        <tr class="table-light fw-bold fs-6">
                            <td colspan="4" class="text-end text-uppercase">সর্বমোট (Total):</td>
                            <td class="text-end text-success">{{ number_format($totalAmount, 2) }} ৳</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            <!-- ৪. সিগনেচার এরিয়া (প্রিন্টের সময় কাজে আসবে) -->
            <div class="row mt-5 pt-4 d-none d-print-flex">
                <div class="col-4 text-center">
                    <div class="border-top border-dark pt-1">প্রস্তুতকারীর স্বাক্ষর</div>
                </div>
                <div class="col-4 text-center">
                    <div class="border-top border-dark pt-1">যাচাইকারীর স্বাক্ষর</div>
                </div>
                <div class="col-4 text-center">
                    <div class="border-top border-dark pt-1">অনুমোদনকারীর স্বাক্ষর</div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
