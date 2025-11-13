<style>
    .form-horizontal {
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
</style>

{!! Form::open(['route' => 'makePayments.cp.st.status','class' => 'form-horizontal']) !!}
    <!-- Section: Form -->
    <fieldset class="border p-3 mb-4">
        <legend class="float-none w-auto px-2">তথ্য হাল নাগাদ করুন</legend>
        <input type="hidden" name="film_id" value="@php echo $film->id; @endphp">
        <input type="hidden" name="request_id" value="@php echo $auth_user->id; @endphp">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-white" style="background-color: #8dc542;">
                        <tr>
                            <th>{{ 'No.' }}</th>
                            <th>{{ 'Item Name' }}</th>
                            <th>{{ 'Price' }}</th>
                            <th>{{ 'Day/Bar' }}</th>
                            <th>{{ 'Amount' }}</th>
                            <th>{{ 'M. Day/Bar' }}</th>
                            <th>{{ 'M. Amount' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($details as $row)
                            <tr>
                                <input type="hidden" name="details_id[]" value="{{ $row->id }}">
                                <input type="hidden" name="details_item_amt[]" value="{{ $row->item_amt }}">
                                <td>{{ $i++ }}</td>
                                <td>{{ $row->name_bn }} </td>
                                <td class="item_amt">{{ $row->item_amt }}</td>
                                <td>{{ $row->request_days }}</td>
                                <td>{{ $row->request_total_amt }}</td>
                                <td><input type="number" name="app_days[]" class="form-control form-control-sm app_days" onkeyup="cal_total_amt(this)" value="{{ $row->app_days }}"></td>
                                <td><input type="number" name="app_total_amt[]" class="form-control form-control-sm app_total_amt" value="{{ $row->app_total_amt }}" readonly></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12 pt-4">
                <label for="" class="form-label">অবস্থা পরিবর্তন করুন</label> <br>
                <input type="radio" name="status" value="forward"> <span>চেক এবং ফরোয়ার্ড</span>
                <input type="radio" name="status" value="approved"> <span>অনুমোদন</span>
                <input type="radio" name="status" value="backward"> <span>চেক এবং ব্যাকওয়ার্ড</span>
                <input type="radio" name="status" value="reject"> <span>প্রত্যাখ্যান</span>
            </div>
            <div class="col-12 mt-3">
                <label for="log_remarks" class="form-label">মন্তব্য</label>
                <textarea class="form-control" id="log_remarks" name="log_remarks" rows="2"></textarea>
            </div>
        </div>
    </fieldset>


    <!-- Submit Field -->
    <div class="form-group col-sm-12" style="text-align-last: right;">
        {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('makePayments.cp.forward.table') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
    </div>
{!! Form::close() !!}

    <script>
        function cal_total_amt(el) {
            const amt = $(el).closest('tr').find('.item_amt').html();
            const day = $(el).val();
            const total = amt * day;
            $(el).closest('tr').find('.app_total_amt').val(total);
        }
    </script>
