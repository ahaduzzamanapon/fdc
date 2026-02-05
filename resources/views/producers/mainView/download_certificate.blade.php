<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin:0; }
        html,body{
            margin:0;
            padding:0;
            font-family: DejaVu Sans, sans-serif;
        }
        .bg{
            position:absolute;
            top:0;
            left:0;
            width:210mm;
            height:297mm;
            z-index:-1;
        }
        .text{
            position:absolute;
            font-size:12px;
        }

        /* ===== Header ===== */
        .cert_no    { top: 96mm; left: 35mm; font-size: 10px; }
        .issue_date { top: 96mm; left: 155mm; font-size: 10px; }
        /* ===== Applicant ===== */
        .name_main { top: 117mm; left: 55mm; font-size: 10px; }

        .name { top: 147mm; left: 97mm; }
        .nid  { top: 153mm; left: 97mm; }
        .tin  { top: 159mm; left: 97mm; }

        /* ===== Organization ===== */
        .org_name { top: 182mm; left: 97mm; }
        .org_tin  { top: 188mm; left: 97mm; }
        .trade    { top: 194mm; left: 97mm; }
        .address  { top: 199mm; left: 97mm; }
    </style>
</head>

<body>

    <img class="bg" src="{{ public_path('images/certificate/FDC-certificate-A4.jpeg') }}">

    <!-- 🔥 Header -->
    <div class="text cert_no">
        CERT-{{ $producer->id }}
    </div>
    <div class="text issue_date">
        {{ date('d-m-Y') }}
    </div>
    <!-- 🔥 Applicant -->
    <div class="text name_main">
        {{ $producer->owners_name }}
    </div>


    <div class="text name">
        {{ $producer->owners_name }}
    </div>
    <div class="text nid">
        {{ $producer->owners_nid }}
    </div>
    <div class="text tin">
        {{ $producer->tin_number }}
    </div>

    <!-- 🔥 Organization -->
    <div class="text org_name">
        {{ $producer->organization_name }}
    </div>
    <div class="text org_tin">
        {{ $producer->tin_number }}
    </div>
    <div class="text trade">
        {{ $producer->trade_license }}
    </div>

    <div class="text address">
        {{ $producer->address }}
    </div>


</body>
</html>
