<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ __('messages.registration') }}</title>
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
            <span class="text-center" style="font-weight: 650;font-size: 19px;">{{ __('messages.producer_registration_form') }}</span>
        </div>

        <form action="{{ route('producers_register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <div class="row">

                    <!-- Organization Info -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.organization_information') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('organization_name', __('messages.organization_name')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('organization_name', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('address', __('messages.address')) !!}
                                 <span class="text-danger">*</span>
                                {!! Form::text('address', null, ['class' => 'form-control', 'required']) !!} 
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('phone_number', __('messages.phone_number')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('phone_number', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('email', __('messages.email')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('password', __('messages.password_label')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('password', null, ['required','style="border: 1px solid #8dc641;border-radius: 4px;padding: 4px;"']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Bank Details -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.bank_related_information') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('bank_name', __('messages.bank_name')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('bank_name', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_branch', __('messages.branch')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('bank_branch', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_account_number', __('messages.account_number')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('bank_account_number', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_attachment', __('messages.attachment')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::file('bank_attachment', ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Tax Info -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.tax_related_information') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('tin_number', __('messages.tin_number')) !!}
                                {!! Form::text('tin_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('tin_attachment', __('messages.tin_attachment')) !!}
                                {!! Form::file('tin_attachment', ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('vat_registration_number', __('messages.vat_registration_number')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::number('vat_registration_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('vat_attachment', __('messages.vat_attachment')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::file('vat_attachment', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Trade License -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.trade_license') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('trade_license', __('messages.trade_license_number')) !!}
                                {!! Form::text('trade_license', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('trade_license_validity_date', __('messages.validity_date')) !!}
                                {!! Form::date('trade_license_validity_date', null, ['class' => 'form-control date']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('trade_license_attachment', __('messages.attachment')) !!}
                                {!! Form::file('trade_license_attachment', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Nominee Info -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.nominee_information') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('nominee_name', __('messages.name')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('nominee_name', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_relation', __('messages.relation')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('nominee_relation', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_nid', __('messages.nid')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::text('nominee_nid', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_photo', __('messages.photo')) !!}
                                <span class="text-danger">*</span>
                                {!! Form::file('nominee_photo', ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Business Agreements -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.business_agreements') }}</legend>
                        <div class="row">
                            @foreach (['partnership', 'ltd_company', 'somobay', 'other'] as $type)
                                <div class="col-md-12" style="padding: 15px;">
                                    {!! Form::label("{$type}_agreement", [
                                        'partnership' => __('messages.partnership_deed_copy'),
                                        'ltd_company' => __('messages.limited_company_info'),
                                        'somobay' => __('messages.cooperative_society_info'),
                                        'other' => __('messages.others')
                                    ][$type]) !!}
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('messages.name') }}</th>
                                                <th>{{ __('messages.attachment') }}</th>
                                                <td>
                                                    <span href="#" class="btn btn-success add-row" data-type="{{ $type }}">{{ __('messages.add_new') }}</span>
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
                                                    <span class="btn btn-danger remove-row">{{ __('messages.delete') }}</span>
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
                <td><input type="text" name="${type}_name[]" class="form-control"></td>
                <td><input type="file" name="${type}_attachment[]" class="form-control"></td>
                <td><span class="btn btn-danger remove-row">{{ __('messages.delete') }}</span></td>
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
                        <a href="{{ route('login') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>&nbsp;
                        <button type="reset" class="btn btn-secondary">{{ __('messages.reset') }}</button>&nbsp;
                        <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
                    </div>

                </div>
            </div>
        </form>

        <div class="login-footer">
            <span>{{ __('messages.copyright_bfdc') }}</span>
            <span>{{ __('messages.developed_by') }}: <strong><a href="https://mysoftheaven.com">Mysoftheaven (BD) Ltd.</a></strong></span>
        </div>
    </div>
</body>


</html>