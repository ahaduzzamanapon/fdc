@extends('layouts.default')

@section('title') বুকিং @parent @stop

@section('content')
    <style>
        .flatpickr-day.booked,
        td.booked {
            background: #dc3545 !important;
            color: white !important;
            cursor: not-allowed;
        }

        .flatpickr-day.pending,
        td.pending {
            background: #ffc107 !important;
            color: black !important;
        }

        td.draft {
            background: #6c757d !important;
            /* Grey for draft */
            color: white !important;
        }

        td.rejected {
            background: #dc3545 !important;
            /* Red for rejected, but still selectable */
            color: white !important;
        }

        td.past-date {
            background: #d3d3d3 !important; /* Light gray */
            color: #ccc !important;
            cursor: not-allowed !important;
        }
        td.today .day-number {
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            width: 40px; /* Adjust size as needed */
            height: 40px; /* Adjust size as needed */
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        td.day-available {
            cursor: pointer;
        }

        td.day-available:hover {
            background: #e9ecef !important;
        }

        th {
            background: #198754 !important;
            color: white !important;
        }

        /* Custom Calendar Styles */
        .custom-calendar {
            width: 100%;
            border-collapse: separate;
            border-spacing: 7px;
        }

        .custom-calendar th,
        .custom-calendar td {
            padding: 8px;
            vertical-align: top;
            box-shadow: 0px 0px 4px 1px #b7b7b7;
            border-radius: 10px;
        }
        .custom-calendar td:hover{
            background: #e9ecef;
            cursor: pointer;
            transform: scale(1.1);
            transition: 0.2s ease-in-out;
        }

        .custom-calendar th {
            background-color: #f2f2f2;
            text-align: center;
            font-size: 23px;
        }

        .day-number {
            font-weight: bold;
            font-size: 24px;
            place-self: center;
            color: black;
        }

        .shift-container {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 5px;
        }

        .shift-btn {
            padding: 2px 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            cursor: pointer;
            font-size: 0.8em;
            background-color: #f9f9f9;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .shift-btn:hover {
            transform: scale(1.1);
            background-color: #007bff;
            color: white;

        }

        .shift-btn.booked {
            background-color: #dc3545;
            color: white;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .shift-btn.pending {
            background-color: #ffc107;
            color: black;
        }
    </style>

    <div @class(['content'])>
        @include('flash::message')

        <div @class(['card'])>
            <div @class(['card-header'])>
                <h5 class="card-title d-inline">{{ __('messages.booking_form') }}</h5>
                <span class="float-right">
                    <a class="btn btn-primary pull-right" href="{{ route('producer.booking') }}">বুকিং তালিকা</a>
                </span>
            </div>

            <div @class(['card-body'])>
                <div @class(['row'])>
                    <div @class(['col-md-4'])>
                        <label for="film_type" @class(['form-label'])>{{ 'সেবা নির্বাচন' }}</label>
                        <select id="film_type" @class(['form-select'])>
                            <option value="">{{ 'সেবা নির্বাচন করুন' }}</option>
                            <option value="film">সিনেমা </option>
                            <option value="drama">নাটক</option>
                            <option value="docufilm">প্রামান্যচিত্র</option>
                            <option value="realityshow">রিয়েলিটি শো</option>
                        </select>
                    </div>
                    <div @class(['col-md-4'])>
                        <label id="film_id_label" for="film_id" @class(['form-label'])>{{ 'আবেদনকৃত সেবা' }}</label>
                        <select id="film_id" @class(['form-select'])>
                            <option value="">{{ 'সেবা নির্বাচন করুন' }}</option>
                        </select>
                    </div>

                    {{-- <div @class(['col-md-3']) id="film_balance_div">
                        <label for="film_balance"
                            @class(['form-label'])>{{ __('messages.remaining_balance') }}</label>
                        <input type="number" @class(['form-control']) id="film_balance" readonly>
                    </div> --}}
                    {{-- সেবার ধরণ --}}
                    <div @class(['col-md-4'])>
                        <label for="service_type" @class(['form-label'])>সেবার ধরণ</label>
                        <select id="service_type" @class(['form-select'])>
                            <option value="">সেবার ধরণ নির্বাচন</option>
                            <option value="day">দিন</option>
                            <option value="shift">শিফট</option>
                            <option value="package">প্যাকেজ</option>
                        </select>
                    </div>
                </div>

                <div @class(['row', 'g-3', 'mt-3'])>
                    <!-- Category Select -->
                    <div @class(['col-md-4'])>
                        <label for="category_id"
                            @class(['form-label'])>{{ __('messages.select_category_label') }}</label>
                        <select id="category_id" @class(['form-select'])>
                            <option value="">{{ __('messages.select_category_placeholder') }}</option>
                            @foreach (\App\Models\ItemCategory::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name_bn }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Item Select -->
                    <div @class(['col-md-4'])>
                        <label for="item_id" @class(['form-label'])>{{ __('messages.select_item') }}</label>
                        <select id="item_id" @class(['form-select'])></select>
                    </div>
                </div>

                <div id="booking_ui_div" class="row g-3 mt-3 align-items-end" style="display: none;">
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <button type="button" id="start_date_btn" class="btn btn-outline-primary w-100"
                            data-bs-toggle="modal" data-bs-target="#calendarModal" data-date-type="start">Select Start
                            Date</button>
                        <input type="hidden" id="start_date_input">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <button type="button" id="end_date_btn" class="btn btn-outline-primary w-100"
                            data-bs-toggle="modal" data-bs-target="#calendarModal" data-date-type="end" disabled>Select End
                            Date</button>
                        <input type="hidden" id="end_date_input">
                    </div>
                    <div class="col-md-4" id="shift_dropdown_wrapper">
                        <label for="shift_id_dropdown" class="form-label">Shift</label>
                        <select id="shift_id_dropdown" class="form-select" disabled>
                            <option value="">Select Shift</option>
                        </select>
                    </div>
                </div>

                <div @class(['d-flex', 'justify-content-end', 'mt-3']) id="add_cart_div" style="display: none;">
                    <button @class(['btn', 'btn-primary']) onclick="add_to_cart()">
                        {{ __('messages.add_to_booking_list') }}
                    </button>
                </div>

                <!-- Booking Cart Table -->
                <form action="{{ route('producer.producer_booking_request') }}" method="POST" id="booking_request_form">
                    @csrf
                    <input type="hidden" name="film_id" id="form_film_id">
                    <input type="hidden" name="film_type" id="form_film_type">
                    <div @class(['table-responsive', 'mt-4'])>
                        <table @class(['table', 'table-bordered'])>
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
                            {{-- Total Price --}}
                            <tfoot>
                                <tr>
                                    <td colspan="4" @class(['text-end'])>{{ __('messages.total_price_label') }}
                                    </td>
                                    <td><input type="number" readonly @class(['form-control'])
                                            name="total_price_input_total" id="total_price_input_total" value="0"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Final Submit -->
                    <div @class(['row', 'mt-3'])>
                        <div @class(['col-md-8', 'text-end', 'mt-4'])>
                            <button type="button" @class(['btn', 'btn-success'])
                                onclick="submit_booking_request()">{{ __('messages.final_booking') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Calendar Modal -->
        <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="calendarModalLabel">Select Date and Shift</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <button id="prev-month" class="btn btn-primary text-bold">&lt; Previous Month </button>
                            <h3 id="month-year"></h3>
                            <button id="next-month" class="btn btn-primary text-bold">Next Month &gt; </button>
                        </div>
                        <div id="modal_calendar" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script>
        $(document).ready(function() {
            // Film type change logic
            $('#service_type').on('change', function() {
                if (this.value == 'package') {
                    window.location.href = "{{ route('makePayments.package') }}";
                }
            });
        });
    </script>

    <script>
        // --- Global Variables ---
        let last_cart = 0;
        let current_item_data = {};
        let datePickerType = 'start';
        let calendarDate = new Date();

        // --- Helper Functions ---

        function fetchItems() {
            const category_id = $('#category_id').val();
            const service_type = $('#service_type').val();

            $('#booking_ui_div, #add_cart_div').hide();
            $('#item_id').empty().append('<option value="">{{ __('messages.select_item_placeholder') }}</option>');

            if (!category_id || !service_type) return;

            $.ajax({
                url: "{{ route('producer.get_items_by_category') }}",
                type: "GET",
                data: {
                    category_id,
                    service_type
                },
                success: function(data) {
                    $.each(data, function(i, item) {
                        $('#item_id').append(`<option value="${item.id}">${item.name_bn}</option>`);
                    });
                }
            });
        }

        function get_booking_data() {
            const item_id = $('#item_id').val();

            $('#add_cart_div, #booking_ui_div').hide();

            // Reset UI
            $('#start_date_btn').text('Select Start Date');
            $('#end_date_btn').text('Select End Date').prop('disabled', true);
            $('#start_date_input, #end_date_input').val('');
            $('#shift_id_dropdown').empty().append('<option value="">Select Shift</option>').prop('disabled', true);

            if (!item_id) return;

            const service_type = $('#service_type').val();
            $.ajax({
                url: "{{ route('producer.get_booking_date') }}",
                type: "GET",
                data: {
                    item_id,
                    service_type
                },
                success: function(data) {
                    current_item_data = data;
                    // Show the unified booking UI
                    $('#booking_ui_div').show();
                    $('#add_cart_div').show();
                    // Hide shift dropdown for 'day' service type
                    if (data.service_type === 'day') {
                        $('#shift_dropdown_wrapper').hide();
                    } else {
                        $('#shift_dropdown_wrapper').show();
                    }
                }
            });
        }

        function renderCustomCalendar(date) {
            const calendarEl = $('#modal_calendar');
            calendarEl.empty();

            const year = date.getFullYear();
            const month = date.getMonth();
            const service_type = $('#service_type').val();
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Normalize today's date

            $('#month-year').text(date.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            }));

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            let table = '<table class="custom-calendar">';
            table +=
                '<thead><tr><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr></thead>';
            table += '<tbody><tr>';

            for (let i = 0; i < firstDay; i++) {
                table += '<td></td>';
            }

            for (let day = 1; day <= daysInMonth; day++) {
                if ((day + firstDay - 1) % 7 === 0 && day !== 1) {
                    table += '</tr><tr>';
                }
                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                table += `<td data-date="${dateStr}"><div class="day-number">${day}</div></td>`;
            }

            table += '</tr></tbody></table>';
            calendarEl.html(table);

            // Determine minDate for end date selection
            let minDateForSelection = null;
            if (datePickerType === 'end' && $('#start_date_input').val()) {
                minDateForSelection = new Date($('#start_date_input').val());
                minDateForSelection.setHours(0, 0, 0, 0); // Normalize to start of day
            }

            // Apply booking statuses and disable past/invalid dates
            calendarEl.find('td[data-date]').each(function() {
                const cellDate = $(this).data('date');
                const currentDate = new Date(cellDate);
                currentDate.setHours(0, 0, 0, 0); // Normalize cell date

                // Mark today's date
                if (currentDate.getTime() === today.getTime()) {
                    $(this).addClass('today');
                }

                // Disable past dates
                if (currentDate < today) {
                    $(this).addClass('past-date').removeClass('day-available');
                    return; // Skip further processing for past dates
                }

                // Disable dates before minDateForSelection (for end date picker)
                if (minDateForSelection && currentDate < minDateForSelection) {
                    $(this).addClass('booked'); // Use 'booked' class for visual disabling
                    return; // Skip further processing for this cell
                }

                if (service_type === 'shift') {
                    populateShiftsInCalendar($(this), cellDate);
                } else { // 'day'
                    populateDaysInCalendar($(this), cellDate);
                }
            });
        }

        function populateShiftsInCalendar(cellElement, cellDate) {
            const {
                item_shifts,
                approved_shifts,
                pending_shifts
            } = current_item_data;
            if (!item_shifts) return;

            let shiftContainer = $('<div class="shift-container"></div>');

            item_shifts.forEach(shift => {
                let isVisible = true;
                if (datePickerType === 'end') {
                    const selectedShiftId = $('#shift_id_dropdown').val();
                    if (!selectedShiftId || shift.id.toString() !== selectedShiftId) isVisible = false;
                }

                if (isVisible) {
                    const isApproved = approved_shifts.some(s => s.date === cellDate && s.shift_id === shift.id);
                    const isPending = pending_shifts.some(s => s.date === cellDate && s.shift_id === shift.id);

                    let shiftButton = $(`<button type="button" class="shift-btn">${shift.name}</button>`);
                    shiftButton.data('shift-id', shift.id).data('shift-name', shift.name).data('date', cellDate);

                    if (isApproved) {
                        shiftButton.addClass('booked').prop('disabled', true);
                    } else if (isPending) {
                        shiftButton.addClass('pending');
                    }
                    shiftContainer.append(shiftButton);
                }
            });
            cellElement.append(shiftContainer);
        }

        function populateDaysInCalendar(cellElement, cellDate) {
            const {
                approved_dates,
                pending_dates,
                draft_dates,
                rejected_dates
            } = current_item_data;
            const approvedDatesFlat = getDatesFromRanges(approved_dates);
            const pendingDatesFlat = getDatesFromRanges(pending_dates);
            const draftDatesFlat = getDatesFromRanges(draft_dates);
            const rejectedDatesFlat = getDatesFromRanges(rejected_dates);

            // Check if already disabled by minDateForSelection
            if (cellElement.hasClass('booked')) return;

            if (approvedDatesFlat.includes(cellDate)) {
                cellElement.addClass('booked'); // Unselectable (red)
            } else {
                // All other statuses (pending, draft, rejected, or free) are selectable
                cellElement.addClass('day-available');
                if (pendingDatesFlat.includes(cellDate)) {
                    cellElement.addClass('pending'); // Selectable (yellow)
                } else if (draftDatesFlat.includes(cellDate)) {
                    cellElement.addClass('draft'); // Selectable (grey)
                } else if (rejectedDatesFlat.includes(cellDate)) {
                    cellElement.addClass('rejected'); // Selectable (red, but still clickable)
                }
            }
        }

        function getDatesFromRanges(ranges) {
            let dates = [];
            if (!ranges) return dates;
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

        window.add_to_cart = function() {
            const item_id = $('#item_id').val();
            const category_id = $('#category_id').val();
            const service_type = $('#service_type').val();
            const booking_start_date = $('#start_date_input').val();
            const booking_end_date = $('#end_date_input').val();
            const shift_id = (service_type === 'shift') ? $('#shift_id_dropdown').val() : null;

            if (!item_id || !category_id || !booking_start_date || !booking_end_date) {
                alert("Please select start and end dates.");
                return;
            }
            if (service_type === 'shift' && !shift_id) {
                alert("Please select a shift.");
                return;
            }

            $.ajax({
                url: "{{ route('producer.add_to_cart') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    item_id,
                    category_id,
                    booking_start_date,
                    booking_end_date,
                    shift_id
                },
                success: function(data) {
                    last_cart++;
                    const row = `
                        <tr id="row_${last_cart}">
                            <td>
                                ${last_cart}
                                <input type="hidden" name="item_id[]" value="${data.item_id}">
                                <input type="hidden" name="shift_id[]" value="${data.shift_id || ''}">
                                <input type="hidden" name="category_id[]" value="${data.category_id}">
                                <input type="hidden" name="booking_start_date[]" value="${data.booking_start_date}">
                                <input type="hidden" name="booking_end_date[]" value="${data.booking_end_date}">
                                <input type="hidden" name="total_price[]" value="${data.total_price}">
                            </td>
                            <td>${data.item_name} <br><small>(${data.item_unit})</small> ${data.shift_name ? '<br><small>('+data.shift_name+')</small>' : ''}</td>
                            <td>${data.item_price}</td>
                            <td>${data.booking_start_date} <br> থেকে <br> ${data.booking_end_date}</td>
                            <td>${data.total_price}</td>
                            <td><button type="button" class="btn btn-danger btn-sm" onclick="remove_from_cart(${last_cart})">X</button></td>
                        </tr>`;
                    $('#booking_request_table').append(row);
                    $('#item_id').val('').trigger('change');
                    calculate_total_price();
                },
                error: function() {
                    alert('Failed to add item to cart. Please check the details.');
                }
            });
        }

        window.remove_from_cart = function(index) {
            $('#row_' + index).remove();
            calculate_total_price();
        }

        function calculate_total_price() {
            let total = 0;
            $('input[name="total_price[]"]').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $('#total_price_input_total').val(total);
        }

        window.submit_booking_request = function() {
            if (last_cart === 0) {
                alert("{{ __('messages.booking_list_empty') }}");
                return false;
            }
            const film_balance = parseFloat($('#film_balance').val()) || 0;
            const total_price = parseFloat($('#total_price_input_total').val()) || 0;
            const film_id = $('#form_film_id').val();
            const film_type = $('#form_film_type').val();

            // if (film_type === 'film' && total_price > film_balance) {
            //     alert("{{ __('messages.no_film_balance') }}");
            //     return false;
            // }

            if (!film_id) {
                alert("অ্যাপ্লিকেশন নির্বাচন করুন");
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
                if (result.isConfirmed) $('#booking_request_form').submit();
            });
        }

        // --- Document Ready ---
        $(document).ready(function() {
            // Film type change logic
            $('#film_type').on('change', function() {
                const filmType = $(this).val();
                if (filmType === 'film') {
                    var appTitle = 'আবেদনকৃত সিনেমা'
                    var appTitleOption = 'সিনেমা নির্বাচন করুন'
                } else if (filmType === 'drama') {
                    var appTitle = 'আবেদনকৃত নাটক'
                    var appTitleOption = 'নাটক নির্বাচন করুন'
                } else if (filmType === 'docufilm') {
                    var appTitle = 'আবেদনকৃত প্রামান্যচিত্র'
                    var appTitleOption = 'প্রামান্যচিত্র নির্বাচন করুন'
                } else if (filmType === 'realityshow') {
                    var appTitle = 'আবেদনকৃত রিয়েলিটি শো'
                    var appTitleOption = 'রিয়েলিটি শো নির্বাচন করুন'
                } else {
                    var appTitle = 'আবেদনকৃত সেবা'
                    var appTitleOption = 'সেবা নির্বাচন করুন'
                }
                $('#film_id_label').text(appTitle);

                // $('#film_balance_div').toggle(filmType === 'film');
                $('#film_id').empty().append( `<option value=""> ${appTitleOption} </option>`);
                $('#form_film_type').val(filmType);

                if (!filmType) return;

                $.ajax({
                    url: "{{ route('producer.get_application') }}",
                    type: "GET",
                    data: {
                        filmId: filmType
                    },
                    success: function(data) {
                        $.each(data, function(i, item) {
                            $('#film_id').append(
                                `<option value="${item.id}">${item.film_title}</option>`
                            );
                        });
                    }
                });

                if (filmType === 'film') {
                    $.ajax({
                        url: "{{ route('producer.get_applicant_balance') }}",
                        type: "GET",
                        data: {
                            filmId: filmType
                        },
                        success: function(data) {
                            $('#film_balance').val(data);
                        }
                    });
                } else {
                    $('#film_balance').val('');
                }
            });

            $('#film_id').on('change', function() {
                $('#form_film_id').val($(this).val());
            });

            // Setup main event listeners
            $('#category_id').on('change', fetchItems);
            $('#service_type').on('change', fetchItems);
            $('#item_id').on('change', get_booking_data);

            // Modal Calendar Setup
            $('#calendarModal').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                datePickerType = button.data('date-type');
                $(this).find('.modal-title').text(
                    `Select ${datePickerType === 'start' ? 'Start' : 'End'} Date`);
                calendarDate = new Date(); // Reset to current month
                renderCustomCalendar(calendarDate);
            });

            // Custom Calendar Navigation
            $('#prev-month').on('click', function() {
                calendarDate.setMonth(calendarDate.getMonth() - 1);
                renderCustomCalendar(calendarDate);
            });

            $('#next-month').on('click', function() {
                calendarDate.setMonth(calendarDate.getMonth() + 1);
                renderCustomCalendar(calendarDate);
            });

            // Delegated event handlers for modal content
            $('#modal_calendar').on('click', '.shift-btn:not(.booked)', function() {
                const date = $(this).data('date');
                const shiftId = $(this).data('shift-id');
                const shiftName = $(this).data('shift-name');

                if (datePickerType === 'start') {
                    $('#start_date_btn').text(date);
                    $('#start_date_input').val(date);
                    $('#shift_id_dropdown').html(`<option value="${shiftId}">${shiftName}</option>`).prop(
                        'disabled', true);
                    $('#end_date_btn').prop('disabled', false);
                    $('#end_date_btn').text('Select End Date');
                    $('#end_date_input').val('');
                } else {
                    const startDate = $('#start_date_input').val();
                    if (new Date(date) < new Date(startDate)) {
                        alert('End date cannot be before start date.');
                        return;
                    }
                    $('#end_date_btn').text(date);
                    $('#end_date_input').val(date);
                }
                $('#calendarModal').modal('hide');
            });

            $('#modal_calendar').on('click', 'td.day-available', function() {
                const date = $(this).data('date');
                if (datePickerType === 'start') {
                    $('#start_date_btn').text(date);
                    $('#start_date_input').val(date);
                    $('#end_date_btn').prop('disabled', false);
                    $('#end_date_btn').text('Select End Date');
                    $('#end_date_input').val('');
                } else {
                    const startDate = $('#start_date_input').val();
                    if (new Date(date) < new Date(startDate)) {
                        alert('End date cannot be before start date.');
                        return;
                    }
                    $('#end_date_btn').text(date);
                    $('#end_date_input').val(date);
                }
                $('#calendarModal').modal('hide');
            });
        });
    </script>
@endsection
@endsection
