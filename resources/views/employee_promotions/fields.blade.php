<div class="row">
    <!-- কর্মকর্তা / কর্মচারী -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('user_id', 'কর্মকর্তা / কর্মচারী ', ['class' => 'control-label']) !!}
            <span style="color:red">*</span>
            {!! Form::select('user_id', $users, null, ['class' => 'form-control select2', 'id' => 'promotion_user_id', 'required' => true]) !!}
        </div>
    </div>

    <!-- পরিবর্তনের ধরণ -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('change_type', 'পরিবর্তনের ধরণ ', ['class' => 'control-label']) !!}
            <span style="color:red">*</span>
            {!! Form::select('change_type', [
                'promotion' => 'পদোন্নতি (Promotion)',
                'increment' => 'ইনক্রিমেন্ট (Increment)',
                'joining'   => 'যোগদান (Joining)',
                'transfer'  => 'বদলী/পদায়ন (Transfer/Posting)',
                'other'     => 'অন্যান্য (Other)'
            ], null, ['class' => 'form-control', 'required' => true]) !!}
        </div>
    </div>

    <!-- কার্যকরী মাস / তারিখ -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('effect_month', 'কার্যকরী মাস / তারিখ (Effect Month/Date) ', ['class' => 'control-label']) !!}
            <span style="color:red">*</span>
            {!! Form::date('effect_month', isset($promotion) ? $promotion->effect_month : date('Y-m-d'), ['class' => 'form-control', 'required' => true]) !!}
        </div>
    </div>

    <!-- ডিপার্টমেন্ট -->
    <div class="col-md-4 mt-3">
        <div class="form-group">
            {!! Form::label('department_id', 'ডিপার্টমেন্ট ', ['class' => 'control-label']) !!}
            {!! Form::select('department_id', $departments, null, ['class' => 'form-control', 'id' => 'department_id']) !!}
        </div>
    </div>

    <!-- পদবী -->
    <div class="col-md-4 mt-3">
        <div class="form-group">
            {!! Form::label('designation_id', 'পদবী ', ['class' => 'control-label']) !!}
            {!! Form::select('designation_id', $designations, null, ['class' => 'form-control', 'id' => 'designation_id']) !!}
        </div>
    </div>

    <!-- অফিসার শ্রেণী -->
    <div class="col-md-4 mt-3">
        <div class="form-group">
            {!! Form::label('staff_class', 'অফিসার শ্রেণী ', ['class' => 'control-label']) !!}
            {!! Form::select('staff_class', [
                '' => 'শ্রেণী নির্বাচন করুন',
                '1' => '১ম শ্রেণী (Class A)',
                '2' => '২য় শ্রেণী (Class B)',
                '3' => '৩য় শ্রেণী (Class C)',
                '4' => '৪র্থ শ্রেণী (Class D)',
            ], null, ['class' => 'form-control', 'id' => 'staff_class']) !!}
        </div>
    </div>

    <!-- গ্রেড -->
    <div class="col-md-4 mt-3">
        <div class="form-group">
            {!! Form::label('grade', 'গ্রেড ', ['class' => 'control-label']) !!}
            {!! Form::select('grade', [
                '' => 'গ্রেড নির্বাচন করুন',
                '1' => '১ম গ্রেড',
                '2' => '২য় গ্রেড',
                '3' => '৩য় গ্রেড',
                '4' => '৪র্থ গ্রেড',
                '5' => '৫ম গ্রেড',
                '6' => '৬ষ্ঠ গ্রেড',
                '7' => '৭ম গ্রেড',
                '8' => '৮ম গ্রেড',
                '9' => '৯ম গ্রেড',
                '10' => '১০ম গ্রেড',
                '11' => '১১তম গ্রেড',
                '12' => '১২তম গ্রেড',
                '13' => '১৩তম গ্রেড',
                '14' => '১৪তম গ্রেড',
                '15' => '১৫তম গ্রেড',
                '16' => '১৬তম গ্রেড',
            ], null, ['class' => 'form-control', 'id' => 'grade']) !!}
        </div>
    </div>

    <!-- বেসিক বেতন -->
    <div class="col-md-4 mt-3">
        <div class="form-group">
            {!! Form::label('basic_salary', 'বেসিক বেতন (টাকা) ', ['class' => 'control-label']) !!}
            <span style="color:red">*</span>
            {!! Form::number('basic_salary', null, ['class' => 'form-control', 'id' => 'basic_salary', 'step' => '0.01', 'required' => true]) !!}
        </div>
    </div>

    <!-- এন্ট্রি তারিখ (created_at) -->
    <div class="col-md-4 mt-3">
        <div class="form-group">
            {!! Form::label('created_at_custom', 'রেকর্ড তৈরির তারিখ (Created At)', ['class' => 'control-label']) !!}
            {!! Form::date('created_at_custom', isset($promotion) && $promotion->created_at ? \Carbon\Carbon::parse($promotion->created_at)->format('Y-m-d') : date('Y-m-d'), ['class' => 'form-control']) !!}
        </div>
    </div>

    <!-- মন্তব্য -->
    <div class="col-md-12 mt-3">
        <div class="form-group">
            {!! Form::label('remarks', 'বিবরণ / মন্তব্য', ['class' => 'control-label']) !!}
            {!! Form::textarea('remarks', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'ইনক্রিমেন্ট বা পদোন্নতির সার্কুলার/আদেশ নম্বর এবং বিস্তারিত লিখুন...']) !!}
        </div>
    </div>

    @if(!isset($promotion))
    <!-- প্রোফাইল অটো-আপডেট চেকবক্স -->
    <div class="col-md-12 mt-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="update_user_profile" name="update_user_profile" value="1" checked>
            <label class="form-check-label font-weight-bold" for="update_user_profile">
                এই রেকর্ড অনুযায়ী কর্মকর্তার মূল প্রোফাইল (ডিপার্টমেন্ট, পদবী, গ্রেড ও স্কেল) স্বয়ংক্রিয়ভাবে আপডেট করুন।
            </label>
        </div>
    </div>
    @endif
</div>

<div class="clearfix"></div>

<!-- জমা দিন -->
<div class="form-group col-sm-12 mt-4 text-end">
    {!! Form::submit('সংরক্ষণ করুন', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('employeePromotions.index') }}" class="btn btn-danger">বাতিল করুন</a>
</div>

@section('footer_scripts')
<script>
    $(document).ready(function() {
        $('#promotion_user_id').change(function() {
            var userId = $(this).val();
            if (userId) {
                $.ajax({
                    url: "{{ route('employeePromotions.getUserInfo') }}",
                    type: "GET",
                    data: { user_id: userId },
                    success: function(res) {
                        if (res.success && res.data) {
                            if (res.data.department_id) $('#department_id').val(res.data.department_id);
                            if (res.data.designation_id) $('#designation_id').val(res.data.designation_id);
                            if (res.data.staff_class) $('#staff_class').val(res.data.staff_class);
                            if (res.data.grade) $('#grade').val(res.data.grade);
                            if (res.data.basic_salary) $('#basic_salary').val(res.data.basic_salary);
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
