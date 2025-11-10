@extends('layouts.default')

@section('title') বুকিং @parent @stop

@section('content')
    <style>
        .flatpickr-day.booked {
            background: #dc3545 !important;
            color: white !important;
            cursor: not-allowed;
        }
        .flatpickr-day.pending {
            background: #ffc107 !important;
            color: black !important;
        }

        th {
            background: #198754 !important;
            color: white !important;
        }
        /* Custom Calendar Styles */
        .custom-calendar { width: 100%; border-collapse: collapse; }
        .custom-calendar th, .custom-calendar td { border: 1px solid #ddd; padding: 8px; vertical-align: top; }
        .custom-calendar th { background-color: #f2f2f2; text-align: center; }
        .custom-calendar td { height: 100px; }
        .day-number { font-weight: bold; }

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
                <h4 @class(['mb-0'])>{{ __('messages.booking_form') }}</h4>
            </div>

            <div @class(['card-body'])>
                <div @class(['row'])>
                    <div @class(['col-md-4'])>
                        <label for="film_type" @class(['form-label'])>{{ 'টাইপ নির্বাচন' }}</label>
                        <select id="film_type" @class(['form-select'])>
                            <option value="">{{ 'টাইপ নির্বাচন করুন' }}</option>
                            <option value="film">ফিল্ম অ্যাপ্লিকেশন </option>
                            <option value="drama">নাটক অ্যাপ্লিকেশন</option>
                            <option value="docufilm">প্রামান্যচিত্র অ্যাপ্লিকেশন</option>
                            <option value="realityshow">রিয়েলিটি শো অ্যাপ্লিকেশন</option>
                        </select>
                    </div>
                    <div @class(['col-md-4'])>
                        <label for="film_id" @class(['form-label'])>{{ 'অ্যাপ্লিকেশন নির্বাচন' }}</label>
                        <select id="film_id" @class(['form-select'])>
                            <option value="">{{ 'অ্যাপ্লিকেশন নির্বাচন করুন' }}</option>
                        </select>
                    </div>

                    <div @class(['col-md-3']) id="film_balance_div">
                        <label for="film_balance"
                            @class(['form-label'])>{{ __('messages.remaining_balance') }}</label>
                        <input type="number" @class(['form-control']) id="film_balance" readonly>
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
                    <div @class(['col-md-4'])>
                        <label for="service_type" @class(['form-label'])>সেবার ধরণ</label>
                        <select id="service_type" @class(['form-select'])>
                            <option value="">সেবার ধরণ নির্বাচন</option>
                            <option value="day">দিন</option>
                            <option value="shift">শিফট</option>
                        </select>
                    </div>
                    <!-- Item Select -->
                    <div @class(['col-md-4'])>
                        <label for="item_id" @class(['form-label'])>{{ __('messages.select_item') }}</label>
                        <select id="item_id" @class(['form-select'])></select>
                    </div>
                </div>

                <div @class(['row', 'g-3', 'mt-3']) id="booking_date_div">
                    <!-- Start Date -->
                    <div @class(['col-md-6'])>
                        <label for="booking_start_date"
                            @class(['form-label'])>{{ __('messages.start_date') }}</label>
                        <input type="text" @class(['form-control']) id="booking_start_date"
                            placeholder="{{ __('messages.select_date') }}">
                    </div>
                    <!-- End Date -->
                    <div @class(['col-md-6'])>
                        <label for="booking_end_date" @class(['form-label'])>{{ __('messages.end_date') }}</label>
                        <input type="text" @class(['form-control']) id="booking_end_date"
                            placeholder="{{ __('messages.select_date') }}">
                    </div>
                </div>

                <div id="shift_booking_div" class="row g-3 mt-3 align-items-end" style="display: none;">
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <button type="button" id="shift_start_date_btn" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#calendarModal" data-date-type="start">Select Start Date</button>
                        <input type="hidden" id="shift_start_date_input">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <button type="button" id="shift_end_date_btn" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#calendarModal" data-date-type="end" disabled>Select End Date</button>
                        <input type="hidden" id="shift_end_date_input">
                    </div>
                    <div class="col-md-4">
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
                            <button id="prev-month" class="btn btn-outline-secondary">&lt;</button>
                            <h5 id="month-year"></h5>
                            <button id="next-month" class="btn btn-outline-secondary">&gt;</button>
                        </div>
                        <div id="modal_calendar" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script>
        // --- Global Variables ---
        let last_cart = 0;
        let current_item_data = {};
        let datePickerType = 'start'; // 'start' or 'end'
        let calendarDate = new Date();

        // --- Helper Functions ---

        function fetchItems() {
            const category_id = $('#category_id').val();
            const service_type = $('#service_type').val();
            
            $('#booking_date_div, #shift_booking_div, #add_cart_div').hide();
            $('#item_id').empty().append('<option value="">{{ __("messages.select_item_placeholder") }}</option>');
            
            if (!category_id || !service_type) return;

            $.ajax({
                url: "{{ route('producer.get_items_by_category') }}",
                type: "GET",
                data: { category_id, service_type },
                success: function(data) {
                    $.each(data, function(i, item) {
                        $('#item_id').append(`<option value="${item.id}">${item.name_bn}</option>`);
                    });
                }
            });
        }

        function get_booking_data() {
            const item_id = $('#item_id').val();
            const service_type = $('#service_type').val();

            $('#add_cart_div, #booking_date_div, #shift_booking_div').hide();
            
            if (service_type === 'day') {
                $('#booking_start_date, #booking_end_date').val('');
            } else if (service_type === 'shift') {
                $('#shift_start_date_btn').text('Select Start Date');
                $('#shift_end_date_btn').text('Select End Date').prop('disabled', true);
                $('#shift_start_date_input, #shift_end_date_input').val('');
                $('#shift_id_dropdown').empty().append('<option value="">Select Shift</option>').prop('disabled', true);
            }

            if (!item_id) return;

            $.ajax({
                url: "{{ route('producer.get_booking_date') }}",
                type: "GET",
                data: { item_id, service_type },
                success: function(data) {
                    current_item_data = data;
                    if (data.service_type === 'day') {
                        $('#booking_date_div').show();
                        setup_day_booking(data);
                        $('#add_cart_div').show();
                    } else if (data.service_type === 'shift') {
                        $('#shift_booking_div').show();
                        $('#add_cart_div').show();
                    }
                }
            });
        }

        function setup_day_booking(data) {
            const { approved_dates, pending_dates } = data;
            const approvedDatesFlat = getDatesFromRanges(approved_dates);
            const pendingDatesFlat = getDatesFromRanges(pending_dates);

            const onDayCreate = function(dObj, dStr, fp, dayElem) {
                const date = dayElem.dateObj.toISOString().split('T')[0];
                if (approvedDatesFlat.includes(date)) dayElem.classList.add("booked");
                if (pendingDatesFlat.includes(date)) dayElem.classList.add("pending");
            };

            const endPicker = flatpickr("#booking_end_date", {
                dateFormat: "Y-m-d", minDate: "today", disable: approved_dates, onDayCreate,
                onClose: function(selectedDates, dateStr) {
                    const start = $('#booking_start_date').val();
                    if (!start || !dateStr) return;
                    if (new Date(dateStr) < new Date(start)) alert("{{ __('messages.end_date_after_start_date') }}");
                    if (checkOverlap(start, dateStr, approved_dates)) alert("{{ __('messages.time_already_booked') }}");
                }
            });

            flatpickr("#booking_start_date", {
                dateFormat: "Y-m-d", minDate: "today", disable: approved_dates, onDayCreate,
                onChange: function(selectedDates, dateStr) { endPicker.set('minDate', dateStr); }
            });
        }

        function renderCustomCalendar(date) {
            const calendarEl = $('#modal_calendar');
            calendarEl.empty();
            
            const year = date.getFullYear();
            const month = date.getMonth();

            $('#month-year').text(date.toLocaleString('default', { month: 'long', year: 'numeric' }));

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            let table = '<table class="custom-calendar">';
            table += '<thead><tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr></thead>';
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

            // Now, populate shifts
            const { item_shifts, approved_shifts, pending_shifts } = current_item_data;
            if (!item_shifts) return;

            calendarEl.find('td[data-date]').each(function() {
                const cellDate = $(this).data('date');
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
                        shiftButton.data('shift-id', shift.id);
                        shiftButton.data('shift-name', shift.name);
                        shiftButton.data('date', cellDate);

                        if (isApproved) {
                            shiftButton.addClass('booked').prop('disabled', true);
                        } else if (isPending) {
                            shiftButton.addClass('pending');
                        }
                        shiftContainer.append(shiftButton);
                    }
                });
                $(this).append(shiftContainer);
            });
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

        function checkOverlap(start, end, ranges) {
            const s = new Date(start), e = new Date(end);
            for (let r of ranges) {
                const rStart = new Date(r.from), rEnd = new Date(r.to);
                if (s <= rEnd && e >= rStart) return true;
            }
            return false;
        }

        window.add_to_cart = function() {
            const item_id = $('#item_id').val();
            const category_id = $('#category_id').val();
            const service_type = $('#service_type').val();
            let booking_start_date, booking_end_date, shift_id;

            if (service_type === 'day') {
                booking_start_date = $('#booking_start_date').val();
                booking_end_date = $('#booking_end_date').val();
                if (!item_id || !category_id || !booking_start_date || !booking_end_date) {
                    alert("{{ __('messages.fill_all_information') }}");
                    return;
                }
            } else if (service_type === 'shift') {
                booking_start_date = $('#shift_start_date_input').val();
                booking_end_date = $('#shift_end_date_input').val();
                shift_id = $('#shift_id_dropdown').val();
                if (!item_id || !category_id || !booking_start_date || !booking_end_date || !shift_id) {
                    alert("Please select start date, end date, and shift.");
                    return;
                }
            }

            $.ajax({
                url: "{{ route('producer.add_to_cart') }}",
                type: "POST",
                data: { _token: '{{ csrf_token() }}', item_id, category_id, booking_start_date, booking_end_date, shift_id },
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
                error: function() { alert('Failed to add item to cart. Please check the details.'); }
            });
        }

        window.remove_from_cart = function(index) {
            $('#row_' + index).remove();
            calculate_total_price();
        }

        function calculate_total_price() {
            let total = 0;
            $('input[name="total_price[]"]').each(function() { total += parseFloat($(this).val()) || 0; });
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

            if (film_type === 'film' && total_price > film_balance) {
                alert("{{ __('messages.no_film_balance') }}");
                return false;
            }
            if (!film_id) {
                alert("অ্যাপ্লিকেশন নির্বাচন করুন");
                return false;
            }

            Swal.fire({
                title: "Are you sure?", icon: "warning", showCancelButton: true,
                confirmButtonColor: "#3085d6", cancelButtonColor: "#d33", confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) $('#booking_request_form').submit();
            });
        }

        // --- Document Ready ---
        $(document).ready(function() {
            // Film type change logic
            $('#film_type').on('change', function() {
                const filmType = $(this).val();
                $('#film_balance_div').toggle(filmType === 'film');
                $('#film_id').empty().append('<option value="">{{ 'অ্যাপ্লিকেশন নির্বাচন করুন' }}</option>');
                $('#form_film_type').val(filmType); // Update hidden input

                if (!filmType) return;

                $.ajax({
                    url: "{{ route('producer.get_application') }}",
                    type: "GET",
                    data: { filmId: filmType },
                    success: function(data) {
                        $.each(data, function(i, item) {
                            $('#film_id').append(`<option value="${item.id}">${item.film_title}</option>`);
                        });
                    }
                });

                if (filmType === 'film') {
                    $.ajax({
                        url: "{{ route('producer.get_applicant_balance') }}",
                        type: "GET",
                        data: { filmId: filmType },
                        success: function(data) {
                            $('#film_balance').val(data);
                        }
                    });
                } else {
                    $('#film_balance').val('');
                }
            });

            $('#film_id').on('change', function() {
                $('#form_film_id').val($(this).val()); // Update hidden input
            });

            // Setup main event listeners
            $('#category_id').on('change', fetchItems);
            $('#service_type').on('change', fetchItems);
            $('#item_id').on('change', get_booking_data);

            // Modal Calendar Setup
            $('#calendarModal').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                datePickerType = button.data('date-type');
                $(this).find('.modal-title').text(`Select ${datePickerType === 'start' ? 'Start' : 'End'} Date`);
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

            // Delegated event handler for shift clicks in custom calendar
            $('#modal_calendar').on('click', '.shift-btn:not(.booked)', function() {
                const date = $(this).data('date');
                const shiftId = $(this).data('shift-id');
                const shiftName = $(this).data('shift-name');

                if (datePickerType === 'start') {
                    $('#shift_start_date_btn').text(date);
                    $('#shift_start_date_input').val(date);
                    $('#shift_id_dropdown').html(`<option value="${shiftId}">${shiftName}</option>`).prop('disabled', true);
                    $('#shift_end_date_btn').prop('disabled', false);
                    $('#shift_end_date_btn').text('Select End Date');
                    $('#shift_end_date_input').val('');
                } else { // 'end'
                    const startDate = $('#shift_start_date_input').val();
                    if (new Date(date) < new Date(startDate)) {
                        alert('End date cannot be before start date.');
                        return;
                    }
                    $('#shift_end_date_btn').text(date);
                    $('#shift_end_date_input').val(date);
                }
                $('#calendarModal').modal('hide');
            });
        });
    </script>
@endsection
@endsection