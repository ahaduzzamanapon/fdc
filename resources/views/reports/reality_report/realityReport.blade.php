<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Film Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h4 class="mb-3 text-center">Reality Show Report</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>ফিল্মের নাম</th>
                    <th>আবেদনকারীর নাম</th>
                    <th>প্রতিষ্ঠানের নাম</th>
                    <th>অবস্থান</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reality as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row['film_title'] }}</td>
                        <td>{{ $row['applicant_name'] }}</td>
                        <td>{{ $row['organization_name'] }}</td>
                        <td>
                            <span class="badge bg-{{ $row['status'] == 'approved' ? 'success' : 'warning' }}">
                                {{ ucfirst($row['status']) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
