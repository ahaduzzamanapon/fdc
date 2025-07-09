




@php
    $employees = \App\Models\User::all()->pluck('name_bn', 'id')->prepend('কর্মচারী নির্বাচন করুন', '')->toArray();
@endphp

<!-- কর্মচারী -->
@if(Auth::user()->user_role == 1)
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('employee_id', 'কর্মচারী', ['class' => 'control-label']) !!}
            {!! Form::select('employee_id', $employees, null, ['class' => 'form-control date', 'autocomplete' => 'off','required']) !!}
        </div>
    </div>
@endif

<!-- শুরুর তারিখ -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('from_date', 'শুরুর তারিখ', ['class' => 'control-label']) !!}
        {!! Form::text('from_date',null, ['class' => 'form-control date', 'autocomplete' => 'off', 'id' => 'from_date']) !!}
    </div>
</div>

<!-- শেষ তারিখ -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('to_date', 'শেষ তারিখ', ['class' => 'control-label']) !!}
        {!! Form::text('to_date',null, ['class' => 'form-control date', 'autocomplete' => 'off', 'id' => 'to_date']) !!}
    </div>
</div>

<!-- মোট দিন -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('total_day', 'মোট দিন', ['class' => 'control-label']) !!}
        {!! Form::text('total_day', null, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => true, 'id' => 'total_day']) !!}
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('leave_type', 'ছুটির ধরণ', ['class' => 'control-label']) !!}
        {!! Form::select('leave_type', ['1' => 'ক্যাসুয়াল ছুটি', '2' => 'সিক লিভ'], null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'leave_type', 'placeholder' => 'ছুটির ধরণ নির্বাচন করুন']) !!}
    </div>
</div>
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {

        setTimeout(function () {
            $('#to_date').trigger('change');
        }, 1000);
        $('#from_date, #to_date').change(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            if (from_date && to_date) {
                // Split date parts to avoid timezone offset issues
                var date1Parts = from_date.split("-");
                var date2Parts = to_date.split("-");
                // Create date objects (YYYY, MM-1, DD)
                var date1 = new Date(date1Parts[2], date1Parts[1] - 1, date1Parts[0]);
                var date2 = new Date(date2Parts[2], date2Parts[1] - 1, date2Parts[0]);

                var time_difference = date2.getTime() - date1.getTime();
                var days_difference = Math.ceil(time_difference / (1000 * 60 * 60 * 24)) + 1;

                if (isNaN(days_difference) || days_difference < 1) {
                    $('#total_day').val('');
                } else {
                    $('#total_day').val(days_difference);
                }
            } else {
                $('#total_day').val('');
            }
        });
    });
</script>

@endsection

<!-- মন্তব্য -->
<div class="col-md-12">
    <div class="form-group">
        {!! Form::label('remark', 'মন্তব্য', ['class' => 'control-label']) !!}
        {!! Form::textarea('remark', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- জমা দিন -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('সংরক্ষণ করুন', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('leaves.index') }}" class="btn btn-danger">বাতিল করুন</a>
</div>

