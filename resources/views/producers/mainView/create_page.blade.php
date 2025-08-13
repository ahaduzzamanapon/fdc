@extends('layouts.default')

@section('title') বুকিং @parent @stop

@section('content')
    <style>
        .flatpickr-day.booked {
            background: #dc3545 !important;
            color: white !important;
            cursor: not-allowed;
        }

        th {
            background: #198754 !important;
            color: white !important;
        }
    </style>

    <div class="content">
        @include('flash::message')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ __('messages.booking_form') }}</h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="film_id" class="form-label">{{ __('messages.select_film') }}</label>
                        <select id="film_id" class="form-select">
                            <option value="">{{ __('messages.select_film_placeholder') }}</option>
                            @foreach (\App\Models\FilmApplication::where('producer_id', Auth::guard('producer')->user()->id)->where('desk', 'MD Approved')->get() as $FilmApplication)
                                <option data-balance="{{ $FilmApplication->balance }}" value="{{ $FilmApplication->id }}">
                                    {{ $FilmApplication->film_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="film_balance" class="form-label">{{ __('messages.remaining_balance') }}</label>
                        <input type="number" class="form-control" id="film_balance" readonly>
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <!-- Category Select -->
                    <div class="col-md-4">
                        <label for="category_id" class="form-label">{{ __('messages.select_category_label') }}</label>
                        <select id="category_id" class="form-select">
                            <option value="">{{ __('messages.select_category_placeholder') }}</option>
                            @foreach (\App\Models\ItemCategory::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name_bn }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Item Select -->
                    <div class="col-md-4">
                        <label for="item_id" class="form-label">{{ __('messages.select_item') }}</label>
                        <select id="item_id" class="form-select"></select>
                    </div>
                    <!-- Item Select -->
                    <div class="col-md-4">
                        <label for="shift_id" class="form-label">{{ __('messages.select_shift') }}</label>
                        <select id="shift_id" class="form-select"></select>
                    </div>
                </div>

                <div class="row g-3 mt-3" id="booking_date_div" style="display: none;">
                    <!-- Start Date -->
                    <div class="col-md-6">
                        <label for="booking_start_date" class="form-label">{{ __('messages.start_date') }}</label>
                        <input type="text" class="form-control" id="booking_start_date" placeholder="{{ __('messages.select_date') }}">
                    </div>
                    <!-- End Date -->
                    <div class="col-md-6">
                        <label for="booking_end_date" class="form-label">{{ __('messages.end_date') }}</label>
                        <input type="text" class="form-control" id="booking_end_date" placeholder="{{ __('messages.select_date') }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3" id="add_cart_div" style="display: none;">
                    <button class="btn btn-primary" onclick="add_to_cart()">
                        {{ __('messages.add_to_booking_list') }}
                    </button>
                </div>

                <!-- Booking Cart Table -->
                <form action="{{ route('producer.producer_booking_request') }}" method="POST" id="booking_request_form">
                    @csrf
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.serial') }}</th>
                                    <th>{{ __('messages.description_label') }}</th>
                                    <th>{{ __('messages.rate') }}</th>
                                    <th>{{ __('messages.date_label') }}</th>
                                    <th>{{ __('messages.total_price_label') }}</th>
                                    <th>{{ __('messages.action_label') }}</th>
                                </tr>
                            </thead>
                            <tbody id="booking_request_table"></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end">{{ __('messages.total_price_label') }}</td>
                                    <td><input type="number" readonly class="form-control" name="total_price_input_total"
                                            id="total_price_input_total" value="0"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Total Price -->
                    <div class="row mt-3">

                        <div class="col-md-8 text-end mt-4">
                            <button type="button" class="btn btn-success" onclick="submit_booking_request()">{{ __('messages.final_booking') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            $(document).ready(function () {
                $('#film_id').on('change', function () {
                    var filmId = $(this).val();
                    var balance = $('#film_id option[value="' + filmId + '"]').data('balance');
                    $('#film_balance').val(balance);
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                let bookedRanges = [], bookedDates = [];
                let last_cart = 0;

                $('#category_id').on('change', function () {
                    $('#item_id').empty();
                    const category_id = $(this).val();
                    console.log(category_id);

                    if (!category_id) return;

                    $.ajax({
                        url: "{{ route('producer.get_items_by_category') }}",
                        type: "GET",
                        data: { category_id },
                        success: function (data) {
                            $('#item_id').append('<option value="">{{ __('messages.select_item_placeholder') }}</option>');
                            $.each(data, function (i, item) {
                                $('#item_id').append(`<option value="${item.id}">${item.name_bn}</option>`);
                            });
                        }
                    });
                });
                $('#item_id').on('change', function () {
                    $('#shift_id').empty();
                    const item_id = $(this).val();
                    if (!item_id) return;

                    $.ajax({
                        url: "{{ route('producer.get_shift_by_item') }}",
                        type: "GET",
                        data: { item_id },
                        success: function (data) {
                            $('#shift_id').append('<option value="">{{ __('messages.select_shift_placeholder') }}</option>');
                            $.each(data, function (i, shift) {
                                $('#shift_id').append(`<option value="${shift.id}">${shift.name}</option>`);
                            });
                        }
                    });
                });






                $('#shift_id').on('change', function () {
                    const shift_id = $('#shift_id').val();
                    const item_id = $('#item_id').val();
                    $('#booking_date_div, #add_cart_div').hide();
                    $('#booking_start_date, #booking_end_date').val('');

                    let exist = false;
                    $('input[name="item_id[]"]').each(function () {
                        if ($(this).val() == item_id) exist = true;
                    });

                    if (exist) {
                        alert("{{ __('messages.item_already_added') }}");
                        return;
                    }

                    if (item_id) {
                        $.ajax({
                            url: "{{ route('producer.get_booking_date_by_shift') }}",
                            type: "GET",
                            data: { shift_id },
                            success: function (data) {
                                bookedRanges = data;
                                bookedDates = getBookedDates(data);

                                $('#booking_date_div, #add_cart_div').show();

                                flatpickr("#booking_start_date", {
                                    dateFormat: "Y-m-d",
                                    minDate: "today",
                                    disable: bookedRanges,
                                    onDayCreate: highlightBooked,
                                    onChange: function (selectedDates, dateStr) {
                                        endPicker.set('minDate', dateStr);
                                    }
                                });

                                const endPicker = flatpickr("#booking_end_date", {
                                    dateFormat: "Y-m-d",
                                    disable: bookedRanges,
                                    onDayCreate: highlightBooked,
                                    onClose: function (selectedDates, dateStr) {
                                        const start = $('#booking_start_date').val();
                                        if (!start) return;

                                        if (new Date(dateStr) < new Date(start)) {
                                            alert("{{ __('messages.end_date_after_start_date') }}");
                                            $('#item_id').trigger('change');
                                        }

                                        if (checkOverlap(start, dateStr, bookedRanges)) {
                                            alert("{{ __('messages.time_already_booked') }}");
                                            $('#item_id').trigger('change');
                                        }
                                    }
                                });
                            }
                        });
                    }
                });

                function highlightBooked(dObj, dStr, fp, dayElem) {
                    const date = dayElem.dateObj.toISOString().split('T')[0];
                    if (bookedDates.includes(date)) {
                        dayElem.classList.add("booked");
                    }
                }

                function getBookedDates(ranges) {
                    let dates = [];
                    ranges.forEach(range => {
                        let current = new Date(range.from + "T00:00:00");
                        const end = new Date(range.to + "T00:00:00");
                        while (current <= end) {
                            dates.push(current.toISOString().split('T')[0]);
                            current.setDate(current.getDate() + 1);
                        }
                    });
                    return dates;
                }

                function checkOverlap(start, end, ranges) {
                    const s = new Date(start), e = new Date(end);
                    for (let r of ranges) {
                        const rStart = new Date(r.from), rEnd = new Date(r.to);
                        if (s <= rEnd && e >= rStart) return true;
                    }
                    return false;
                }

                window.add_to_cart = function () {
                    const item_id = $('#item_id').val();
                    const category_id = $('#category_id').val();
                    const shift_id = $('#shift_id').val();
                    const booking_start_date = $('#booking_start_date').val();
                    const booking_end_date = $('#booking_end_date').val();

                    if (!item_id || !category_id || !booking_start_date || !booking_end_date || !shift_id) {
                        alert("{{ __('messages.fill_all_information') }}");
                        return;
                    }

                    $.ajax({
                        url: "{{ route('producer.add_to_cart') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            item_id, category_id, shift_id, booking_start_date, booking_end_date
                        },
                        success: function (data) {
                            film_id = $('#film_id').val();
                            last_cart++;
                            const row = `
                                        <tr id="row_${last_cart}">
                                            <td>
                                                ${last_cart}
                                                <input type="hidden" name="item_id[]" value="${data.item_id}">
                                                <input type="hidden" name="shift_id[]" value="${data.shift_id}">
                                                <input type="hidden" name="category_id[]" value="${data.category_id}">
                                                <input type="hidden" name="booking_start_date[]" value="${data.booking_start_date}">
                                                <input type="hidden" name="booking_end_date[]" value="${data.booking_end_date}">
                                                <input type="hidden" name="total_price[]" value="${data.total_price}">
                                                <input type="hidden" name="film_id" value="${film_id}">
                                            </td>
                                            <td>${data.item_name} <br><small>(${data.item_unit})</small> <br><small>(${data.shift_name})</small></td>
                                            <td>${data.item_price}</td>
                                            <td>${data.booking_start_date} <br> থেকে <br> ${data.booking_end_date}</td>
                                            <td>${data.total_price}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="remove_from_cart(${last_cart})">X</button>
                                            </td>
                                        </tr>`;
                            $('#booking_request_table').append(row);
                            $('#item_id').val('');
                            $('#booking_start_date').val('');
                            $('#booking_end_date').val('');
                            calculate_total_price();
                        }
                    });
                }

                window.remove_from_cart = function (index) {
                    $('#row_' + index).remove();
                    calculate_total_price();
                }

                function calculate_total_price() {
                    let total = 0;
                    $('input[name="total_price[]"]').each(function () {
                        total += parseFloat($(this).val());
                    });
                    $('#total_price_input_total').val(total);
                }

                window.submit_booking_request = function () {
                    if (last_cart === 0) {
                        alert("{{ __('messages.booking_list_empty') }}");
                        return false;
                    }

                    film_balance = $('#film_balance').val();
                    total_price = $('#total_price_input_total').val();


                    
                    if (total_price < film_balance) {
                        alert("{{ __('messages.no_film_balance') }}");
                        return false;
                    }
                    
                    
                    Swal.fire({
                    title: "Are you sure?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#booking_request_form').submit();
                        }
                    });
                }
            });
        </script>
    @endsection

@endsection