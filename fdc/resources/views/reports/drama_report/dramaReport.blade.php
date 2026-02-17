<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Film Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h4 class="mb-3 text-center">Drama Report</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr style="font-size: 12px">
                    <th>#</th>
                    <th>ক্যাটাগরি</th>
                    <th>চলচ্চিত্রের নাম</th>
                    <th>আবেদন নম্বর</th>
                    <th>প্রযোজনার তারিখ</th>
                    <th>বাজেট</th>
                    <th>সেবার ধরন</th>
                    <th>প্রযোজনার ধরন</th>
                    <th>চলচ্চিত্রের সময়কাল (মিনিট)</th>
                    <th>পরিচালকের নাম</th>
                    <th>চিত্রগ্রাহক</th>
                    <th>প্রধান চরিত্র</th>
                    <th>বিদেশি অংশগ্রহণ</th>
                    <th>চিত্রনাট্যকার</th>
                    <th>আবেদনকারীর নাম</th>
                    <th>প্রতিষ্ঠানের নাম</th>
                    <th>প্রতিষ্ঠানের ঠিকানা</th>
                    <th>প্রতিষ্ঠানের ফোন</th>
                    <th>প্রতিষ্ঠানের ইমেইল</th>
                    <th>স্ট্যাটাস</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drama as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row['category'] }}</td>
                        <td>{{ $row['film_title'] }}</td>
                        <td>{{ $row['film_serial_no'] }}</td>
                        <td>{{ $row['production_start_date'] }}</td>
                        <td>{{ $row['budget_amount'] }}</td>
                        <td>{{ $row['service_type'] }}</td>
                        <td>{{ $row['production_type'] }}</td>
                        <td>{{ $row['film_duration'] }}</td>
                        <td>{{ $row['director_name'] }}</td>
                        <td>{{ $row['cameraman_name'] }}</td>
                        <td>{{ $row['main_cast'] }}</td>
                        <td>{{ $row['foreign_participation'] }}</td>
                        <td>{{ $row['script_writer_name'] }}</td>
                        <td>{{ $row['applicant_name'] }}</td>
                        <td>{{ $row['organization_name'] }}</td>
                        <td>{{ $row['organization_address'] }}</td>
                        <td>{{ $row['organization_phone'] }}</td>
                        <td>{{ $row['organization_email'] }}</td>
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
