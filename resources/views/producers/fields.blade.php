
<style>
     /* .form-group {
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
        } */
</style>





  <!-- Organization Info -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">প্রতিষ্ঠানের তথ্য</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('organization_name', 'প্রতিষ্ঠানের নাম') !!}
                                {!! Form::text('organization_name', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('address', 'ঠিকানা') !!}
                                {!! Form::text('address', null, ['class' => 'form-control']) !!} 
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('phone_number', 'ফোন নম্বর') !!}
                                {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('email', 'ই-মেইল') !!}
                                {!! Form::email('email', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('password', 'পাসওয়ার্ড') !!}
                                {!! Form::password('password', null, ['required','style="border: 1px solid #8dc641;border-radius: 4px;padding: 4px;"']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Bank Details -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">ব্যাংক সংক্রান্ত তথ্য</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('bank_name', 'ব্যাংকের নাম') !!}
                                {!! Form::text('bank_name', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_branch', 'শাখা') !!}
                                {!! Form::text('bank_branch', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_account_number', 'একাউন্ট নম্বর') !!}
                                {!! Form::text('bank_account_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_attachment', 'সংযুক্তি') !!}
                                {!! Form::file('bank_attachment', ['class' => 'form-control']) !!}
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
                                {!! Form::number('vat_registration_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('vat_attachment', 'ভ্যাট সংযুক্তি') !!}
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
                                {!! Form::date('trade_license_validity_date', isset($producer->trade_license_validity_date) ? date('Y-m-d', strtotime($producer->trade_license_validity_date)) : null, ['class' => 'form-control']) !!}
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
                                {!! Form::text('nominee_name', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_relation', 'সম্পর্ক') !!}
                                {!! Form::text('nominee_relation', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_nid', 'এনআইডি') !!}
                                {!! Form::text('nominee_nid', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_photo', 'ছবি') !!}
                                {!! Form::file('nominee_photo', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Business Agreements -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">ব্যবসায়িক চুক্তি</legend>
                        <div class="row">
                            <div class="col-md-12" style="padding: 15px;">
                                {!! Form::label('partnership_agreement', '(ক) যৌথ মালিকানাধীন ফার্ম হলে রেজিস্টার্ড পার্টনারশীপ ডীড এর সত্যায়িত ফটোকপি সংযুক্ত করতে হবে।') !!}
                                <br>
                                {!! Form::file('partnership_agreement') !!}
                            </div>
                            
                            <div class="col-md-12" style="padding: 15px;">
                                {!! Form::label('ltd_company_agreement', '(খ) লিমিটেড কোম্পানি হলে সার্টিফিকেট অব ইনকর্পোরেশন, মেমোরেন্ডাম ও আর্টিকেলস অব এসোসিয়েশন এবং কোম্পানীর রেজুলেশন সংযুক্ত করতে হবে।') !!}
                                {!! Form::file('ltd_company_agreement') !!}
                            </div>
                            <div class="col-md-12" style="padding: 15px;">
                                {!! Form::label('somobay_agreement', '(গ) সমবায় সমিতি হলে মেমোরেন্ডাম ও আর্টিকেলস অব এসোসিয়েশন, সমবায় সমিতি অধিদপ্তরের সার্টিফিকেট এবং সমিতির রেজুলেশন সংযুক্ত করতে হবে।') !!}

                                {!! Form::file('somobay_agreement') !!}
                            </div>
                            <div class="col-md-12" style="padding: 15px;">
                                {!! Form::label('other_attachment', '(ঘ) অন্যান্য') !!}
                                                                <br>

                                {!! Form::file('other_attachment') !!}
                            </div>
                        </div>
                    </fieldset>

<!-- Status Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('status', 'Status',['class'=>'control-label']) !!}
        {!! Form::select('status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('producers.index') }}" class="btn btn-danger">Cancel</a>
</div>
