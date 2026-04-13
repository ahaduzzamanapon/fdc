<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin:0; }
        html,body{
            margin:0;
            padding:0;
            font-family: nikosh, DejaVu Sans, sans-serif;
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
            display: inline-block;
        }

        /* ===== Header ===== */
        .cert_no    { top: 96mm; left: 35mm; font-size: 10px; }
        .issue_date { top: 96mm; left: 155mm; font-size: 10px; }
        /* ===== Applicant ===== */
        .name_main { top: 110mm; left: 19mm; right: 19mm; font-size: 10px; }

        .name { top: 147mm; left: 97mm; }
        .nid  { top: 153mm; left: 97mm; white-space: nowrap; width: 60mm; }
        .tin  { top: 159mm; left: 97mm; white-space: nowrap; width: 60mm; }

        /* ===== Organization ===== */
        .org_name { top: 182mm; left: 97mm; }
        .org_tin  { top: 188mm; left: 97mm; white-space: nowrap; width: 60mm;}
        .trade    { top: 194mm; left: 97mm; white-space: nowrap; width: 60mm;}
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


    <!-- 🔥 Applicant with content -->
    <div class="text name_main">
        <p style="font-size: 17px">এই মর্মে প্রত্যয়ন করা যাচ্ছে যে, নিম্নবর্ণিত তথ্য অনুযায়ী বাংলাদেশ চলচ্চিত্র উন্নয়ন কর্পোরেশন-এর যথাযথ কর্তৃপক্ষের আওতায় প্রযোজনা/নির্মাতা প্রতিষ্ঠান, &nbsp; <strong style="font-size: 12px">  {{ $producer->owners_name }}  </strong> .... কে বিএফডিসিতে তালিকাভুক্ত করা হলো।</p>
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
