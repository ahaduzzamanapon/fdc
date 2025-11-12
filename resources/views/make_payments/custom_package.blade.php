@extends('layouts.default')

{{-- Page title --}}
@section('title')
কাস্টম প্যাকেজ {{ __('messages.package') }} @parent
@stop

@section('content')
    <section class="content-header">
    </section>

    <div class="content">
      @include('adminlte-templates::common.errors')
      <div class="card">

        <div class="card-header">
            <h5 class="card-title">কাস্টম প্যাকেজ তৈরি করুন</h5>
        </div>

        <div class="card-body">
            <div class="row">
                {!! Form::open(['route' => 'makePayments.cp.store','class' => 'form-horizontal col-md-12', 'id' => 'submit_booking_request']) !!}
                <div class="row">

                  <!-- Name Field -->
                  <div @class(['col-md-3'])>
                    <label for="film_type" @class(['form-label'])>{{ 'টাইপ নির্বাচন' }}</label>
                    <select id="film_type" name="film_type" @class(['form-select']) required>
                      <option value="">{{ 'নির্বাচন করুন' }}</option>
                      <option value="film">ফিল্ম অ্যাপ্লিকেশন </option>
                      <option value="drama">নাটক অ্যাপ্লিকেশন</option>
                      <option value="docufilm">প্রামান্যচিত্র অ্যাপ্লিকেশন</option>
                      <option value="realityshow">রিয়েলিটি শো অ্যাপ্লিকেশন</option>
                    </select>
                  </div>

                  <!-- Film Field -->
                  <div @class(['col-md-4'])>
                    <label for="film_id" @class(['form-label'])>{{ 'অ্যাপ্লিকেশন নির্বাচন' }}</label>
                    <select id="film_id" name="film_id" @class(['form-select']) required>
                        <option value="">{{ 'নির্বাচন করুন' }}</option>
                    </select>
                  </div>

                  <!-- Service Type Field -->
                  <div @class(['col-md-3'])>
                    <label for="service_type" @class(['form-label'])>{{ 'সেবার ধরণ' }}</label>
                    <select id="service_type" name="service_type" @class(['form-select']) onchange="getItems()" required>
                        <option value="">{{ 'নির্বাচন করুন' }}</option>
                        <option value="day">দিন</option>
                        <option value="shift">শিফট</option>
                    </select>
                  </div>

                  <!-- Amount Field -->
                  <div class="col-md-2">
                      <div class="form-group">
                          {!! Form::label('amount', __('messages.amount'),['class'=>'control-label']) !!}
                          {!! Form::number('grand_amount', 0, ['class' => 'form-control', 'readonly', 'id' => 'grand_amount']) !!}
                      </div>
                  </div>

                    <!-- Item Search Field -->
                  <div @class(['col-md-6'])>
                    <label for="item_id" @class(['form-label'])>{{ ' আইটেম নির্বাচন ' }}</label>
                    <select id="item_id" @class(['form-select']) onchange="set_items(this.value)">
                      <option value="">{{ 'নির্বাচন করুন' }}</option>
                    </select>
                  </div>
                  <br><br>

                  {{-- Item Table --}}
                  <div class="col-md-12 pt-3">
                    <table class="table table-bordered table-striped">
                      <thead class="thead-light">
                        <tr>
                          <th>Item Name</th>
                          <th>Price</th>
                          <th width="15%">Day</th>
                          <th width="15%">Amount</th>
                          <th width="5%"> Add Item </th>
                        </tr>
                      </thead>
                      <tbody id="custom_package_items">
                      </tbody>
                    </table>
                  </div>

                  <!-- Description Field -->
                  <div class="col-md-12">
                      <div class="form-group ">
                          {!! Form::label('description', __('messages.description'),['class'=>'control-label']) !!}
                          {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
                      </div>
                  </div>

                  <!-- Submit Field -->
                  <div class="form-group col-sm-12" style="text-align-last: right;">
                    <input type="button">
                    {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary' ]) !!}
                    <a href="{{ route('makePayments.package') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
                  </div>

                </div>

                {!! Form::close() !!}
            </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
    <script>
      $('#submit_booking_request').submit(function(e) {
        e.preventDefault();
          values = $('tr').find('.item_total_amount').val();
          if (values == undefined) {
            alert("{{ __('messages.booking_list_empty') }}");
            return false;
          } else {
            this.submit();
          }
      })
    </script>

    <script>
      function set_items(e) {
        data = e.split('---');

        $checkitem = $(`#check-item${data[0]}`);
        if ($checkitem.length) {
          alert('Item already added.');
          return;
        }

        $('#custom_package_items').append(`
          <tr>
            <input type="hidden" id="check-item${data[0]}" name="item_id[]" value="${data[0]}">
            <input type="hidden" class="item_amt" name="item_amt[]" value="${data[1]}">
            <td> ${data[2]} </td>
            <td> ${data[1]} </td>
            <td>
              <input type="number" name="days[]" class="form-control form-control-sm item_day" onkeyup="cal_total_amt(this)" value="1">
            </td>
            <td>
              <input name="item_total_amount[]" class="form-control form-control-sm item_total_amount" value="${data[1]}" readonly>
            </td>
            <td>
              <button type="button" class="btn btn-danger btn-sm">Delete</button>
            </td>
          </tr>
        `);
        cal_grand_total();
      }
    </script>


    <script>
      function cal_total_amt(el) {
        const amt = $(el).closest('tr').find('.item_amt').val();
        const day = $(el).val();
        const total = amt * day;
        $(el).closest('tr').find('.item_total_amount').val(total);
        cal_grand_total();
      }
      function cal_grand_total() {
        let total = 0;
        $('.item_total_amount').each(function() {
          total += parseFloat($(this).val()) || 0;
        });
        $('#grand_amount').val(total);
      }
    </script>


    <script>
      function getItems() {
        const service_type = $('#service_type').val();
        if (!service_type) return;

        $('#item_id').empty().append('<option value="">নির্বাচন করুন</option>');
        $.ajax({
          url: "{{ route('makePayments.get_items_by_type') }}",
          type: "GET",
          data: {
            service_type
          },
          success: function(data) {
            $.each(data, function(i, item) {
              $('#item_id').append(`<option value="${item.id}---${item.amount}---${item.name_bn}">${item.name_bn}</option>`);
            });
          }
        });
      }
    </script>


    <script>
      $(document).ready(function () {
        // Film type change logic
        $('#film_type').on('change', function() {
          const filmType = $(this).val();
          $('#film_balance_div').toggle(filmType === 'film');
          $('#film_id').empty().append(
              '<option value="">{{ 'অ্যাপ্লিকেশন নির্বাচন করুন' }}</option>');
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
        });
      });
    </script>

@endsection
