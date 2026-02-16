<!-- 🧍 ব্যক্তিগত তথ্য -->

@php
    $users = \App\Models\User::all()->pluck('name_bn', 'id')->prepend(__('ইউজার নির্বাচন করুন'), '')->toArray();
    $depts = \App\Models\ItemDepartment::all()->pluck('name', 'id')->prepend(__('messages.select_department'), '')->toArray();
@endphp
<div class="col-md-12">
    {{-- <h4><strong>🧍 {{ __('messages.personal_information') }}</strong></h4>
    <hr> --}}
    <div class="row">
        <!-- নাম (বাংলা) -->
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('id', __('ইউজার নির্বাচন করুন'),['class'=>'control-label']) !!}
                {!! Form::select('id', $users, null, ['class' => 'form-control', 'required']) !!}
            </div>
        </div>

        {{--  --}}
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('inv_permission', __('messages.select_department'),['class'=>'control-label']) !!}
                {!! Form::select('inv_permission', $depts, null, ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<!-- জমা দিন -->
<div class="form-group col-sm-12" style="text-align-last: left;">
    {!! Form::submit(__('messages.save_profile'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('invPermissions.index') }}" class="btn btn-danger">{{ __('messages.cancel_profile') }}</a>
</div>


@section('footer_scripts')
    <script>
        $(document).ready(function() {
            $('#dis_id').change(function() {
                var districtId = $(this).val();
                $.ajax({
                    url: "{{ route('get_upazilas') }}",
                    type: "GET",
                    data: {
                        district_id: districtId
                    },
                    success: function(data) {
                        $('#upazila_id').empty();
                        $('#upazila_id').append('<option value="">উপজেলা নির্বাচন করুন</option>');
                        $.each(data, function(index, upajila) {
                            $('#upazila_id').append('<option value="' + upajila.id + '">' + upajila.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
