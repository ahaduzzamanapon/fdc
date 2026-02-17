<style>

    .card {
        box-shadow: 0 0px 4px 10px rgb(0 0 0 / 5%);
        border-radius: 0;
        min-height: 0vh;
        margin: 20px;
    }

</style>


@php
    $employees = \App\Models\User::all()->pluck('name_bn', 'id')->prepend(__('messages.select_employee'), '')->toArray();
@endphp

{{-- @dd(($leave_data)); --}}

<!-- কর্মচারী -->
@if(Auth::user()->user_role == 1)
<div class=" col-md-3">
    <div class="form-group">
        {!! Form::label('employee_id', __('messages.employee'), ['class' => 'control-label']) !!}
        {!! Form::select('employee_id', $employees, old('employee_id'), ['class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
        @error('employee_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
@endif

@if(Auth::user()->user_role == 5)
    <div class="row col-md-12 d-flex justify-content-between">
        <div class="col-md-3 d-flex align-items-center justify-content-between" style="margin-left: -15px">
            <div class="card text-center" style="outline: 1px solid #8dc641;border-radius:5px">
                <div class="card-body d-flex align-items-center justify-content-center" style="padding:10px">
                    <span>{{ __('messages.total_leave') }} {{ $all_leaves->day }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-between">
            <div class="card text-center" style="outline: 1px solid #8dc641;border-radius:5px">
                <div class="card-body d-flex align-items-center justify-content-center" style="padding:10px">
                    <span>{{ __('messages.total_leave_taken') }} {{ $leave_data['leave_taken'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-center justify-content-between">
            <div class="card text-center" style="outline: 1px solid #8dc641;border-radius:5px">
                <div class="card-body d-flex align-items-center justify-content-center" style="padding:10px">
                    <span>{{ __('messages.remaining_leave') }} {{ ( $all_leaves->day - $leave_data['leave_taken']) }}</span>
                </div>
            </div>
        </div>
    </div>
@endif



<!-- শুরুর তারিখ -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('from_date', __('messages.start_date'), ['class' => 'control-label']) !!}
        {!! Form::date('from_date', isset($leave->from_date) ? date('Y-m-d', strtotime($leave->from_date)) : old('from_date'), ['class' => 'form-control date', 'autocomplete' => 'off', 'id' => 'from_date']) !!}
        @error('from_date')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- শেষ তারিখ -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('to_date', __('messages.end_date'), ['class' => 'control-label']) !!}
        {!! Form::date('to_date', isset($leave->to_date) ? date('Y-m-d', strtotime($leave->to_date)) : old('to_date'), ['class' => 'form-control date', 'autocomplete' => 'off', 'id' => 'to_date']) !!}
        @error('to_date')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- মোট দিন -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('total_day', __('messages.total_days'), ['class' => 'control-label']) !!}
        {!! Form::text('total_day', old('total_day'), ['class' => 'form-control', 'autocomplete' => 'off', 'readonly' => true, 'id' => 'total_day']) !!}
        @error('total_day')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- ছুটির ধরণ -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('leave_type', __('messages.leave_type_label'), ['class' => 'control-label']) !!}
        {!! Form::select('leave_type', [__('messages.casual_leave') => __('messages.casual_leave'), __('messages.sick_leave') => __('messages.sick_leave')], old('leave_type'), ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'leave_type', 'placeholder' => __('messages.select_leave_type')]) !!}
        @error('leave_type')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- মন্তব্য -->
<div class="col-md-12">
    <div class="form-group">
        {!! Form::label('remark', __('messages.remark'), ['class' => 'control-label']) !!}
        {!! Form::textarea('remark', old('remark'), ['class' => 'form-control', 'rows' => 5]) !!}
        @error('remark')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- জমা দিন -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {{-- @if(auth::user()->user_role == 5)
    <a href="{{ route('leaves.approved', $leave->id) }}" class="btn btn-success">অনুমোদন করুন</a>
    @endif --}}
    @if(isset($leave) && $leave->employee_id != auth()->user()->id)
        {!! Form::submit(__('messages.save_button'), ['class' => 'btn btn-primary']) !!}
    @else
        {!! Form::submit(__('messages.apply_button'), ['class' => 'btn btn-primary']) !!}
    @endif
    <a href="{{ route('leaves.index') }}" class="btn btn-danger">{{ __('messages.cancel_button') }}</a>
</div>

@section('scripts')
<script>
    $(document).ready(function () {
        $('#from_date, #to_date').change(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            if (from_date && to_date) {
                var date1Parts = from_date.split("-");
                var date2Parts = to_date.split("-");

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
