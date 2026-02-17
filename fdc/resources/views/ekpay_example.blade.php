<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="EkPay">
    <title>{{ __('messages.ekpay_example_title') }}</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body class="bg-light">
<div class="container">
    <div class="py-5 text-center">
        <h2>{{ __('messages.hosted_payment_ekpay') }}</h2>
        <p class="lead">{{ __('messages.ekpay_description') }}</p>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">{{ __('messages.your_cart') }}</span>
                <span class="badge badge-secondary badge-pill">3</span>
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{ __('messages.product_name') }}</h6>
                        <small class="text-muted">{{ __('messages.brief_description') }}</small>
                    </div>
                    <span class="text-muted">1000</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{ __('messages.second_product') }}</h6>
                        <small class="text-muted">{{ __('messages.brief_description') }}</small>
                    </div>
                    <span class="text-muted">50</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{ __('messages.third_item') }}</h6>
                        <small class="text-muted">{{ __('messages.brief_description') }}</small>
                    </div>
                    <span class="text-muted">150</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ __('messages.total_bdt') }}</span>
                    <strong>1200 TK</strong>
                </li>
            </ul>
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">{{ __('messages.billing_address') }}</h4>
            <form action="{{ url('/ekpay/pay') }}" method="POST" class="needs-validation">
                <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="firstName">{{ __('messages.full_name') }}</label>
                        <input type="text" name="customer_name" class="form-control" id="customer_name" placeholder=""
                               value="John Doe" required>
                        <div class="invalid-feedback">
                            {{ __('messages.valid_customer_name_required') }}
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="mobile">{{ __('messages.mobile') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">+88</span>
                        </div>
                        <input type="text" name="customer_mobile" class="form-control" id="mobile" placeholder="{{ __('messages.mobile') }}"
                               value="01711xxxxxx" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            {{ __('messages.your_mobile_number_required') }}
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email">{{ __('messages.email') }} <span class="text-muted">{{ __('messages.optional') }}</span></label>
                    <input type="email" name="customer_email" class="form-control" id="email"
                           placeholder="you@example.com" value="you@example.com" required>
                    <div class="invalid-feedback">
                        {{ __('messages.valid_email_required') }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address">{{ __('messages.address') }}</label>
                    <input type="text" class="form-control" id="address" placeholder="1234 Main St"
                           value="93 B, New Eskaton Road" required>
                    <div class="invalid-feedback">
                        {{ __('messages.shipping_address_required') }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address2">{{ __('messages.address_2') }} <span class="text-muted">{{ __('messages.optional') }}</span></label>
                    <input type="text" class="form-control" id="address2" placeholder="{{ __('messages.apartment_or_suite') }}">
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="country">{{ __('messages.country') }}</label>
                        <select class="custom-select d-block w-100" id="country" required>
                            <option value="">{{ __('messages.choose') }}</option>
                            <option value="Bangladesh">{{ __('messages.bangladesh') }}</option>
                        </select>
                        <div class="invalid-feedback">
                            {{ __('messages.valid_country_required') }}
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state">{{ __('messages.state') }}</label>
                        <select class="custom-select d-block w-100" id="state" required>
                            <option value="">{{ __('messages.choose') }}</option>
                            <option value="Dhaka">{{ __('messages.dhaka') }}</option>
                        </select>
                        <div class="invalid-feedback">
                            {{ __('messages.valid_state_required') }}
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip">{{ __('messages.zip') }}</label>
                        <input type="text" class="form-control" id="zip" placeholder="" required>
                        <div class="invalid-feedback">
                            {{ __('messages.zip_code_required') }}
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="same-address">
                    <input type="hidden" value="1200" name="amount" id="total_amount" required/>
                    <label class="custom-control-label" for="same-address">{{ __('messages.shipping_address_same_as_billing') }}</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save-info">
                    <label class="custom-control-label" for="save-info">{{ __('messages.save_info_for_next_time') }}</label>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">{{ __('messages.continue_to_checkout_hosted') }}</button>
            </form>
        </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">{{ __('messages.company_name_copyright') }}</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">{{ __('messages.privacy') }}</a></li>
            <li class="list-inline-item"><a href="#">{{ __('messages.terms') }}</a></li>
            <li class="list-inline-item"><a href="#">{{ __('messages.support') }}</a></li>
        </ul>
    </footer>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</html>
