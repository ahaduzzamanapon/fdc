<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Film Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h4 class="mb-3 text-center">Payment Report</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr style="font-size: 12px">
                    <th>#</th>
                    <th>পেমেন্ট টাইপ</th>
                    <th>পেমেন্ট টাইটেল</th>
                    <th>পেমেন্ট আইডি</th>
                    <th>পেমেন্ট এমাউন্ট</th>
                    <th>পেমেন্ট তারিখ</th>
                    <th>পেমেন্ট স্ট্যাটাস</th>

                </tr>
            </thead>
            <tbody>
                @foreach($payments as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row['type'] }}</td>
                        <td>{{ $row['name'] }}</td>
                        <td>{{ $row['trn_id'] }}</td>
                        <td>{{ $row['amount'] }}</td>
                        <td>{{ $row['paid_at'] }}</td>
                        <td>{{ $row['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
