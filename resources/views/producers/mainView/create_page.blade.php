@extends('layouts.default')

{{-- Page title --}}
@section('title')
বুকিং @parent
@stop

@section('content')
    <style>
        .flatpickr-day.booked {
            background: #ff4d4d !important;
            color: white !important;
            cursor: not-allowed;
        }

        th {
            background: #8dc542 !important;
            color: #000000 !important;
        }
    </style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        {{--<div aria-label="breadcrumb" class="card-breadcrumb">
            <h1>Producers</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>--}}
    </section>

    <!-- Main content -->
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card" width="88vw;">
            <section class="card-header">
                <h5 class="card-title d-inline">প্রোডাক্ট বুকিং করুন </h5>
                <span class="float-right">
                    {{-- <a class="btn btn-primary pull-right" </a> --}}
                </span>
            </section>
            <div class="card-body table-responsive">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="booking_date">ক্যাটাগরি সিলেক্ট করুন</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">ক্যাটাগরি সিলেক্ট করুন</option>
                                    @php
                                        $categories = \App\Models\ItemCategory::all();
                                    @endphp
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name_bn }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="booking_date">আইটেম সিলেক্ট করুন</label>
                                <select name="item_id" id="item_id" class="form-control">
                                    <option value="">আইটেম সিলেক্ট করুন</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="booking_date_div">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="booking_date">শুরুর তারিখ</label>
                                <input type="date" name="booking_start_date" id="booking_start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="booking_date">শেষের তারিখ</label>
                                <input type="date" name="booking_end_date" id="booking_end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="booking_date_div" style="justify-self: right;padding: 19px;margin-bottom: 16px;">
                        <a class="btn btn-primary" id="booking_request_btn" style="width: fit-content;"
                            href="javascript:void(0)" onclick="add_to_cart()">বুকিং লিস্ট এ যোগ
                            করুন</a>
                    </div>
                    <div class="row" id="booking_request_div">
                        <form action="" method="post" id="booking_request_form">
                            @csrf

                            <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ক্রম</th>
                                                <th>বিভাগ</th>
                                                <th>বিবরণ</th>
                                                <th>বিএফডিসি'র <br> বিদ্যমান হার</th>
                                                <th>তারিখ</th>
                                                <th>প্রস্তাবিত হার</th>
                                            </tr>
                                        </thead>
                                        <tbody id="booking_request_table">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" style="text-align: right">সর্বমোট হার</td>
                                                <td><input type="text" name="total_price_input_total" id="total_price_input_total" readonly></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="row" id="booking_date_div" style="justify-self: right;padding: 19px;margin-bottom: 16px;">
                        <a class="btn btn-primary" id="booking_request_btn" style="width: fit-content;">বুকিং প্রস্তাব
                            করুন</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @section('scripts')
        <script>
            $(document).ready(function () {
                $('#category_id').on('change', function () {
                    var category_id = $(this).val();
                    $('#item_id').empty();
                    if (category_id) {
                        $.ajax({
                            url: "{{ route('producer.get_items_by_category') }}",
                            type: "GET",
                            data: {
                                category_id: category_id
                            },
                            success: function (data) {
                                $('#item_id').empty();
                                $('#item_id').append('<option value="">আইটেম সিলেক্ট করুন</option>');
                                $.each(data, function (index, item) {
                                    $('#item_id').append('<option value="' + item.id + '">' + item.name_bn + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#item_id').html('<option value="">আইটেম সিলেক্ট করুন</option>');
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#booking_date_div').hide();

                let bookedRanges = [];
                let bookedDates = [];

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

                function checkOverlap(start, end, blocked) {
                    const s = new Date(start + "T00:00:00");
                    const e = new Date(end + "T00:00:00");

                    for (let range of blocked) {
                        let rStart = new Date(range.from + "T00:00:00");
                        let rEnd = new Date(range.to + "T00:00:00");

                        if (s <= rEnd && e >= rStart) {
                            return true; // overlap
                        }
                    }
                    return false;
                }

                $('#item_id').on('change', function () {
                    var item_id = $(this).val();
                    $('#booking_date_div').hide();
                    $('#booking_start_date').val('');
                    $('#booking_end_date').val('');

                    if (item_id) {
                        $.ajax({
                            url: "{{ route('producer.get_booking_date_by_item') }}",
                            type: "GET",
                            data: { item_id: item_id },
                            success: function (data) {
                                $('#booking_date_div').show();

                                bookedRanges = data;
                                bookedDates = getBookedDates(bookedRanges);

                                const today = new Date().toISOString().split('T')[0];

                                const startPicker = flatpickr("#booking_start_date", {
                                    dateFormat: "Y-m-d",
                                    minDate: today,
                                    disable: bookedRanges,
                                    onDayCreate: function (dObj, dStr, fp, dayElem) {
                                        const date = dayElem.dateObj.toISOString().split('T')[0];
                                        if (bookedDates.includes(date)) {
                                            dayElem.classList.add("booked");
                                        }
                                    },
                                    onChange: function (selectedDates, dateStr) {
                                        if (dateStr) {
                                            endPicker.set('minDate', dateStr); // set min for end_date
                                        }
                                    }
                                });

                                const endPicker = flatpickr("#booking_end_date", {
                                    dateFormat: "Y-m-d",
                                    disable: bookedRanges,
                                    onDayCreate: function (dObj, dStr, fp, dayElem) {
                                        const date = dayElem.dateObj.toISOString().split('T')[0];
                                        if (bookedDates.includes(date)) {
                                            dayElem.classList.add("booked");
                                        }
                                    },
                                    onClose: function (selectedDates, dateStr) {
                                        const start = $('#booking_start_date').val();
                                        const end = dateStr;

                                        if (!start) return;

                                        if (new Date(end) < new Date(start)) {
                                            alert("শেষ তারিখ অবশ্যই শুরুর তারিখের পরে হতে হবে।");
                                            $('#item_id').trigger('change');
                                            return;
                                        }

                                        if (checkOverlap(start, end, bookedRanges)) {
                                            alert("এই তারিখে বুকিং পাওয়া যাচ্ছে না। অনুগ্রহ করে অন্য রেঞ্জ নির্বাচন করুন।");
                                            $('#item_id').trigger('change');
                                            return;
                                        }
                                    }
                                });



                            }
                        });
                    }
                });
            });
        </script>

        <script>
            var last_cart = 0
            function add_to_cart() {
                var item_id = $('#item_id').val();
                var category_id = $('#category_id').val();
                var booking_start_date = $('#booking_start_date').val();
                var booking_end_date = $('#booking_end_date').val();
                if (!item_id || !category_id || !booking_start_date || !booking_end_date) {
                    alert("সঠিক তথ্য প্রদান করুন");
                    return false;
                }
                var data = {
                    item_id: item_id,
                    category_id: category_id,
                    booking_start_date: booking_start_date,
                    booking_end_date: booking_end_date,
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: "{{ route('producer.add_to_cart') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        last_cart++;
                        tr = `<tr>
                                    <td>
                                        ${last_cart}
                                        <input type="hidden" name="item_id[]" value="${data.item_id}">
                                        <input type="hidden" name="category_id[]" value="${data.category_id}">
                                        <input type="hidden" name="booking_start_date[]" value="${data.booking_start_date}">
                                        <input type="hidden" name="booking_end_date[]" value="${data.booking_end_date}">
                                        <input type="hidden" name="total_price[]" value="${data.total_price}">
                                    </td>
                                    <td>${data.item_category_name}</td>
                                    <td>${data.item_name}<br> (${data.item_unit})</td>
                                    <td>${data.item_price}</td>
                                    <td>${data.booking_start_date} <br> to <br> ${data.booking_end_date} </td>
                                    <td>${data.total_price}</td>
                                </tr>
                                `
                        $('#booking_request_table').append(tr);
                        $('#item_id').val('');
                        $('#category_id').val('');
                        $('#booking_start_date').val('');
                        $('#booking_end_date').val('');
                        calculate_total_price()
                    }
                });

            }
            function calculate_total_price() {
                var total_price = 0;
                $('input[name="total_price[]"]').each(function () {
                    total_price += parseInt($(this).val());
                });
                $('#total_price_input_total').val(total_price);
            }
        </script>

    @endsection


@endsection