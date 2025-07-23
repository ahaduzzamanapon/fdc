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
                <h4 class="mb-0">বুকিং ফর্ম</h4>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <!-- Category Select -->
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">ক্যাটাগরি সিলেক্ট করুন</label>
                        <select id="category_id" class="form-select">
                            <option value="">-- ক্যাটাগরি নির্বাচন করুন --</option>
                            @foreach (\App\Models\ItemCategory::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name_bn }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Item Select -->
                    <div class="col-md-6">
                        <label for="item_id" class="form-label">আইটেম সিলেক্ট করুন</label>
                        <select id="item_id" class="form-select"></select>
                    </div>
                </div>

                <div class="row g-3 mt-3" id="booking_date_div" style="display: none;">
                    <!-- Start Date -->
                    <div class="col-md-6">
                        <label for="booking_start_date" class="form-label">শুরুর তারিখ</label>
                        <input type="text" class="form-control" id="booking_start_date" placeholder="তারিখ নির্বাচন করুন">
                    </div>
                    <!-- End Date -->
                    <div class="col-md-6">
                        <label for="booking_end_date" class="form-label">শেষ তারিখ</label>
                        <input type="text" class="form-control" id="booking_end_date" placeholder="তারিখ নির্বাচন করুন">
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3" id="add_cart_div" style="display: none;">
                    <button class="btn btn-primary" onclick="add_to_cart()">
                        ➕ বুকিং তালিকায় যোগ করুন
                    </button>
                </div>

                <!-- Booking Cart Table -->
                <form action="{{ route('producer.producer_booking_request') }}" method="POST" id="booking_request_form">
                    @csrf
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ক্রমিক</th>
                                    <th>বিবরণ</th>
                                    <th>দর</th>
                                    <th>তারিখ</th>
                                    <th>মোট মূল্য</th>
                                    <th>একশন</th>
                                </tr>
                            </thead>
                            <tbody id="booking_request_table"></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end">মোট মূল্য</td>
                                    <td><input type="text" readonly class="form-control" name="total_price_input_total" id="total_price_input_total" value="0"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Total Price -->
                    <div class="row mt-3">
                       
                        <div class="col-md-8 text-end mt-4">
                            <button type="button" class="btn btn-success" onclick="submit_booking_request()">✅ চূড়ান্ত বুকিং</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @section('scripts')
<script>
    $(document).ready(function () {
        let bookedRanges = [], bookedDates = [];
        let last_cart = 0;

        $('#category_id').on('change', function () {
            $('#item_id').empty();
            const category_id = $(this).val();
            if (!category_id) return;

            $.ajax({
                url: "{{ route('producer.get_items_by_category') }}",
                type: "GET",
                data: { category_id },
                success: function (data) {
                    $('#item_id').append('<option value="">-- আইটেম নির্বাচন করুন --</option>');
                    $.each(data, function (i, item) {
                        $('#item_id').append(`<option value="${item.id}">${item.name_bn}</option>`);
                    });
                }
            });
        });

        $('#item_id').on('change', function () {
            const item_id = $(this).val();
            $('#booking_date_div, #add_cart_div').hide();
            $('#booking_start_date, #booking_end_date').val('');

            let exist = false;
            $('input[name="item_id[]"]').each(function () {
                if ($(this).val() == item_id) exist = true;
            });

            if (exist) {
                alert("এই আইটেমটি ইতিমধ্যে যোগ করা হয়েছে।");
                return;
            }

            if (item_id) {
                $.ajax({
                    url: "{{ route('producer.get_booking_date_by_item') }}",
                    type: "GET",
                    data: { item_id },
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
                                    alert("শেষ তারিখ অবশ্যই শুরুর পরে হতে হবে।");
                                    $('#item_id').trigger('change');
                                }

                                if (checkOverlap(start, dateStr, bookedRanges)) {
                                    alert("এই সময়টি ইতিমধ্যে বুক করা হয়েছে। অন্য একটি তারিখ নির্বাচন করুন।");
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
            const booking_start_date = $('#booking_start_date').val();
            const booking_end_date = $('#booking_end_date').val();

            if (!item_id || !category_id || !booking_start_date || !booking_end_date) {
                alert("সব তথ্য পূরণ করুন");
                return;
            }

            $.ajax({
                url: "{{ route('producer.add_to_cart') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    item_id, category_id, booking_start_date, booking_end_date
                },
                success: function (data) {
                    last_cart++;
                    const row = `
                        <tr id="row_${last_cart}">
                            <td>
                                ${last_cart}
                                <input type="hidden" name="item_id[]" value="${data.item_id}">
                                <input type="hidden" name="category_id[]" value="${data.category_id}">
                                <input type="hidden" name="booking_start_date[]" value="${data.booking_start_date}">
                                <input type="hidden" name="booking_end_date[]" value="${data.booking_end_date}">
                                <input type="hidden" name="total_price[]" value="${data.total_price}">
                            </td>
                            <td>${data.item_name} <br><small>(${data.item_unit})</small></td>
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
                alert("বুকিং তালিকা খালি।");
                return;
            }
            if (confirm("আপনি কি নিশ্চিত?")) {
                $('#booking_request_form').submit();
            }
        }
    });
</script>
@endsection

@endsection
