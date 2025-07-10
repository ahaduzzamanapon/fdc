<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@100..900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Noto Sans Bengali", sans-serif;
        }

        body {
            margin: 0;
            font-family: "Noto Sans Bengali", sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .btn-primary:not(:disabled):not(.disabled):active,
        .btn-primary:not(:disabled):not(.disabled).active,
        .show>.btn-primary.dropdown-toggle {
            color: #fff;
            background-color: rgb(90 144 18);
            border-color: rgba(0, 125.25, 60.3055555556, 0.7803921569);
        }

        .btn-primary:focus,
        .btn-primary.focus {
            color: #fff;
            background-color: rgb(95 149 22);
            border-color: rgb(95 149 22);
            box-shadow: 0 0 0 0 rgba(55.1239573679, 203.2673772011, 126.4522706209, 0.5);
        }

        .login-card {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            max-width: 90%;
            width: 100%;
        }

        .login-card .logo {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: -12px;
            gap: 11px;
        }

        .login-card .logo img {
            width: 70px;
            height: 70px;
        }



        .logo-text span {
            font-size: 27px;
            font-weight: 900;
            color: black;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.8rem;
        }

        .form-control {
            border: 1px solid #8dc641;
            border-radius: 4px;
            background-color: #ffffff;
            color: #333;
        }

        .form-control::placeholder {
            color: #777;
        }

        .form-control:focus {
            border-color: #8dc641;
            background-color: #fff;
            box-shadow: none;
        }

        .input-icon {
            position: absolute;
            left: 0px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #fff;
            background-color: #8dc641;
            border: 1px solid #8dc641;
            border-radius: 10px 0px 0px 10px;
            padding: 5px 0px 0px 0px;
            width: 45px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: #8dc641;
            border: none;
            font-weight: 600;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background: #8dc641;
        }

        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 0.25rem;
            color: #dc3545;
        }

        .login-footer {
            font-size: 0.75rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
            flex-wrap: wrap;
            gap: 10px;
            color: #777;
            /* text-align: -webkit-center; */
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
    </style>
</head>

@php
    $designations = \App\Models\Designation::all()->pluck('desi_name', 'id')->prepend('Select Designation', '')->toArray();
    $districts = \App\Models\District::all()->pluck('name_en', key: 'id')->prepend('Select District', '')->toArray();
@endphp

<body>
    <div class="login-card">
        <div class="" style="place-self: center;margin-bottom: 28px;">
            <img src="{{ asset('images/logo.svg') }}" alt="logo">
        </div>
        <div style="justify-self: center;margin-bottom: 15px;padding: 0px 38px;cursor: pointer;">
            <span class="text-center" style="font-weight: 650;font-size: 19px;">প্রযোজক রেজিস্ট্রেশন ফর্ম</span>
        </div>

        <form action="{{ route('producers_register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <div class="row">

                    <!-- Organization Info -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">প্রতিষ্ঠানের তথ্য</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('organization_name', 'প্রতিষ্ঠানের নাম') !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('organization_name', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('address', 'ঠিকানা') !!}
                                 <span class="text-danger">*</span>
                                {!! Form::text('address', null, ['class' => 'form-control', 'required']) !!} 
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('phone_number', 'ফোন নম্বর') !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('phone_number', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('email', 'ই-মেইল') !!}
                                <span class="text-danger">*</span>
                                {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('password', 'পাসওয়ার্ড') !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('password', null, ['required','style="border: 1px solid #8dc641;border-radius: 4px;padding: 4px;"']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Bank Details -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">ব্যাংক সংক্রান্ত তথ্য</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('bank_name', 'ব্যাংকের নাম') !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('bank_name', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_branch', 'শাখা') !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('bank_branch', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_account_number', 'একাউন্ট নম্বর') !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('bank_account_number', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_attachment', 'সংযুক্তি') !!}
                                <span class="text-danger">*</span>
                                {!! Form::file('bank_attachment', ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Tax Info -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">কর সংক্রান্ত তথ্য</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('tin_number', 'টিআইএন নম্বর') !!}
                                {!! Form::text('tin_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('tin_attachment', 'টিআইএন সংযুক্তি') !!}
                                {!! Form::file('tin_attachment', ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('vat_registration_number', 'ভ্যাট রেজিস্ট্রেশন নম্বর') !!}
                                <span class="text-danger">*</span>
                                {!! Form::number('vat_registration_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('vat_attachment', 'ভ্যাট সংযুক্তি') !!}
                                <span class="text-danger">*</span>
                                {!! Form::file('vat_attachment', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Trade License -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">ট্রেড লাইসেন্স</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('trade_license', 'ট্রেড লাইসেন্স নম্বর') !!}
                                {!! Form::text('trade_license', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('trade_license_validity_date', 'বৈধতার তারিখ') !!}
                                {!! Form::date('trade_license_validity_date', null, ['class' => 'form-control date']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('trade_license_attachment', 'সংযুক্তি') !!}
                                {!! Form::file('trade_license_attachment', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Nominee Info -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">নমিনির তথ্য</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('nominee_name', 'নাম') !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('nominee_name', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_relation', 'সম্পর্ক') !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('nominee_relation', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_nid', 'এনআইডি') !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('nominee_nid', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_photo', 'ছবি') !!}
                                <span class="text-danger">*</span>
                                {!! Form::file('nominee_photo', ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Business Agreements -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">ব্যবসায়িক চুক্তি</legend>
                        <div class="row">
                            @foreach (['partnership', 'ltd_company', 'somobay', 'other'] as $type)
                                <div class="col-md-12" style="padding: 15px;">
                                    {!! Form::label("{$type}_agreement", [
                                        'partnership' => '(ক) যৌথ মালিকানাধীন ফার্ম হলে রেজিস্টার্ড পার্টনারশীপ ডীড এর সত্যায়িত ফটোকপি সংযুক্ত করতে হবে।',
                                        'ltd_company' => '(খ) লিমিটেড কোম্পানি হলে সার্টিফিকেট অব ইনকর্পোরেশন, মেমোরেন্ডাম ও আর্টিকেলস অব এসোসিয়েশন এবং কোম্পানীর রেজুলেশন সংযুক্ত করতে হবে।',
                                        'somobay' => '(গ) সমবায় সমিতি হলে মেমোরেন্ডাম ও আর্টিকেলস অব এসোসিয়েশন, সমবায় সমিতি অধিদপ্তরের সার্টিফিকেট এবং সমিতির রেজুলেশন সংযুক্ত করতে হবে।',
                                        'other' => '(ঘ) অন্যান্য'
                                    ][$type]) !!}
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>নাম</th>
                                                <th>সংযুক্তি</th>
                                                <td>
                                                    <span href="#" class="btn btn-success add-row" data-type="{{ $type }}">নতুন করুন</span>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {!! Form::text("{$type}_name[]", null, ['class' => 'form-control']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::file("{$type}_attachment[]", ['class' => 'form-control']) !!}
                                                </td>
                                                <td>
                                                    <span class="btn btn-danger remove-row">মুছে ফেলুন</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>

<script>
    document.querySelectorAll('.add-row').forEach(button => {
        button.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const tableBody = this.closest('table').querySelector('tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="${type}_name" class="form-control"></td>
                <td><input type="file" name="${type}_attachment" class="form-control"></td>
                <td><span class="btn btn-danger remove-row">মুছে ফেলুন</span></td>
            `;
            tableBody.appendChild(newRow);
        });
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-row')) {
            event.target.closest('tr').remove();
        }
    });
</script>

                    <!-- Submit Buttons -->
                    <div class="col-md-12 text-end mt-3" style="text-align-last: right;">
                        <a href="{{ route('login') }}" class="btn btn-danger">বাতিল</a>&nbsp;
                        <button type="reset" class="btn btn-secondary">রিসেট</button>&nbsp;
                        <button type="submit" class="btn btn-primary">জমা দিন</button>
                    </div>

                </div>
            </div>
        </form>

        <div class="login-footer">
            <span>কপিরাইট © ২০২৫ <strong>বাংলাদেশ চলচ্চিত্র উন্নয়ন করপোরেশন - বিএফডিসি</strong></span>
            <span>উন্নয়নে: <strong><a href="https://mysoftheaven.com">Mysoftheaven (BD) Ltd.</a></strong></span>
        </div>
    </div>
</body>


</html>