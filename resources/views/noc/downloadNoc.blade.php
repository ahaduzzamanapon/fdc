<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Certificate</title>

    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            background: #ffffffff;
        }

        .certificate {
            width: 210mm;
            height: 297mm;
            position: relative;
            background: url('{{ asset('assets/images/bg_pass.jpg') }}') no-repeat center center;
            background-size: cover;
            place-self: center;
        }

        .content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-family: 'Georgia', serif;
            color: #000000ff;
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .name {
            font-weight: 400;
            font-size: 42px;
            line-height: 100%;
            color: #3C3F3E;
            font-family: 'Brush Script MT', cursive;
            padding: 20px;
        }

        .description {
            max-width: 170mm;
            margin-bottom: 30px;
            min-width: 82%;
            font-family: Inter;
            font-weight: 400;
            font-size: 16.6px;
            line-height: 21px;
            color: #000000ff;
            text-align: justify;

        }

        .skills {
            display: flex;
            gap: 46px;
            text-align: left;
            border: 1px solid #000000ff;
            padding: 6px 19px;
            min-width: 77%;
            justify-content: space-between;
        }

        .skills ul {
            margin: 0;
            padding: 0;

        }

        .skills ul li {
            font-size: 14px;
            line-height: 22px;
            color: #000000ff;
            max-width: 280px;
        }

        .footer {
            position: absolute;
            bottom: 30mm;
            width: 80%;
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            color: #000000ff;
        }

        .header_text {
            font-family: Playfair Display;
            font-weight: 700;
            font-size: 26px;
            line-height: 100%;
            font-variant: small-caps;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <div class="content">
            <div style="padding-top: 77px;width: 82%;">
                <div class="row" style="justify-self: center;">
                    <span class="header_text">বাংলাদেশ চলচ্চিত্র উন্নয়ন কর্পোরেশন</span>
                </div>

                <div style="padding: 40px 26px 0px;">
                    <div class="col-md-12">
                        <div style="display: flex; align-items: flex-start; font-size: 16px;">
                            <span style="font-weight: 600;">NOC আবেদন ফরম</span>
                        </div>
                        <div style="display: flex; align-items: flex-start; font-size: 16px; padding: 5px 0px;">
                            <span>(সিনেমা মুক্তির অনুমোদন/প্রকাশনার জন্য)</span>
                        </div>
                        <div style="display: flex; align-items: flex-start; font-size: 16px;">
                            <span>তারিখ: {{ date('d-m-Y') }}</span>
                        </div>
                    </div>
                </div>

                <div style="padding: 40px 26px 0px;">
                    <div class="col-md-12">
                        <div style="display: flex; align-items: flex-start; font-size: 16px;">
                            <span style="font-weight: 600;">প্রাপক:</span>
                        </div>
                        <div style="display: flex; align-items: flex-start; font-size: 16px; padding: 5px 0px;">
                            <span>চেয়ারম্যান/ব্যবস্থাপনা পরিচালক</span>
                        </div>
                        <div style="display: flex; align-items: flex-start; font-size: 16px;">
                            <span>বাংলাদেশ ফিল্ম ডেভেলপমেন্ট কর্পোরেশন (BFDC) </span>
                        </div>
                        <div style="display: flex; align-items: flex-start; font-size: 16px;">
                            <span>ঢাকা। </span>
                        </div>
                    </div>
                </div>

                <div style="padding: 40px 26px 0px;">
                    <div class="col-md-12">
                        <div style="display: flex; align-items: flex-start; font-size: 16px;">
                            <span style="font-weight: 600;">বিষয়: চলচ্চিত্র মুক্তির জন্য NOC প্রদানের আবেদন।</span>
                        </div>
                    </div>
                </div>

                <div style="padding: 40px 26px 0px;">
                    <div class="col-md-12">
                        <div style="display: flex; align-items: flex-start; font-size: 16px;">
                            <span style="font-weight: 600;">মাননীয় মহোদয়,</span>
                        </div>
                        <div style="display: flex; align-items: flex-start; font-size: 16px; padding-top: 5px; text-align: start;">
                            <span >আমি নিম্নস্বাক্ষরকারী ( {{ $noc->full_name }} ), আমাদের নির্মিত “ {{ $noc->name }} ” ছবিটি ( {{ date('d-m-Y', strtotime($noc->publish_date)) }} ) তারিখে মুক্তির উদ্দেশ্যে একটি No Objection Certificate (NOC) এর জন্য আবেদন করছি।</span>
                        </div>
                    </div>
                </div>
                <div style="padding: 40px 26px 0px;">
                    <div class="col-md-12">
                        <div style="display: flex; align-items: flex-start; font-size: 16px; padding-top: 5px; text-align: start;">
                            <span >চলচ্চিত্রটির সংশ্লিষ্ট সকল কাগজপত্র যথাযথভাবে সম্পন্ন হয়েছে এবং চলচ্চিত্র মুক্তির ক্ষেত্রে আপনার দপ্তরের কোনো আপত্তি নেই উল্লেখপূর্বক একটি NOC প্রদান করার জন্য অনুরোধ করছি।</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
