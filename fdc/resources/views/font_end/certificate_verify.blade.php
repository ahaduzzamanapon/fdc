<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate Verification</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 40px;
        }

        .card {
            max-width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,.1);
        }

        .badge {
            display: inline-block;
            background: #28a745;
            color: #fff;
            padding: 10px 22px;
            border-radius: 50px;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .badge::before {
            content: "✔ ";
            font-weight: bold;
        }

        .table {
            width: 100%;
            margin-top: 20px;
        }

        .table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
    </style>
</head>

<body>

<div class="card">
    <div class="badge">VERIFIED CERTIFICATE</div>

    <table class="table">
        <tr>
            <td><strong>Certificate No</strong></td>
            <td>CERT-{{ $producer->id }}</td>
        </tr>
        <tr>
            <td><strong>Name</strong></td>
            <td>{{ $producer->owners_name }}</td>
        </tr>
        <tr>
            <td><strong>Organization</strong></td>
            <td>{{ $producer->organization_name }}</td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td style="color:green;font-weight:bold;">
                {{ $producer->reg_status }}
            </td>
        </tr>
        <tr>
            <td><strong>Issued On</strong></td>
            <td>{{ $producer->created_at->format('d M Y') }}</td>
        </tr>
    </table>
</div>

</body>
</html>
