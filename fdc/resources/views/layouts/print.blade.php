<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Include necessary CSS for printing, e.g., Bootstrap or custom print styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            .card-header,
            .btn {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    @yield('content')

    <!-- Optional: Include any necessary JS for printing, if any -->
</body>
</html>
