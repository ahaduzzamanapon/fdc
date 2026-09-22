<div class="row">
    <!-- User Select (if Admin / HR) -->
    @if(!who('staff'))
        <div class="col-md-6 mb-3">
            {!! Form::label('user_id', 'কর্মকর্তা / কর্মচারী:', ['class' => 'form-label font-weight-bold']) !!} <span class="text-danger">*</span>
            {!! Form::select('user_id', $users, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
            @error('user_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    @else
        <div class="col-md-6 mb-3">
            {!! Form::label('user_name', 'কর্মকর্তা / কর্মচারী:', ['class' => 'form-label font-weight-bold']) !!}
            <input type="text" class="form-control" value="{{ Auth::user()->name_bn ?? Auth::user()->name_en }}" readonly>
        </div>
    @endif

    <!-- Training Course Select -->
    <div class="col-md-6 mb-3">
        {!! Form::label('training_id', 'প্রশিক্ষণ কোর্স / বিষয়সূচী (তালিকা থেকে):', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::select('training_id', $courses, null, ['class' => 'form-control select2', 'id' => 'training_id']) !!}
        <small class="text-muted">তালিকায় না থাকলে নিচের কাস্টম শিরোনামের ঘরে লিখুন।</small>
    </div>

    <!-- Custom Title -->
    <div class="col-md-12 mb-3">
        {!! Form::label('title', 'অন্যান্য / কাস্টম প্রশিক্ষণ বিষয়সূচী:', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'প্রশিক্ষণ কোর্সের নাম (যদি উপরোক্ত তালিকায় না থাকে)']) !!}
        @error('title')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Start Date -->
    <div class="col-md-4 mb-3">
        {!! Form::label('start_date', 'শুরুর তারিখ:', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::date('start_date', isset($training) && $training->start_date ? $training->start_date->format('Y-m-d') : null, ['class' => 'form-control', 'id' => 'start_date']) !!}
        @error('start_date')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- End Date -->
    <div class="col-md-4 mb-3">
        {!! Form::label('end_date', 'সমাপ্তির তারিখ:', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::date('end_date', isset($training) && $training->end_date ? $training->end_date->format('Y-m-d') : null, ['class' => 'form-control', 'id' => 'end_date']) !!}
        @error('end_date')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Duration -->
    <div class="col-md-4 mb-3">
        {!! Form::label('duration', 'মেয়াদকাল (সময়সীমা):', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::text('duration', null, ['class' => 'form-control', 'placeholder' => 'যেমন: ৭ দিন, ১ মাস (ফাঁকা রাখলে তারিখ থেকে হিসেব হবে)']) !!}
    </div>

    <!-- Institute -->
    <div class="col-md-6 mb-3">
        {!! Form::label('institute', 'ইনস্টিটিউট / প্রতিষ্ঠান / সংস্থা:', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::text('institute', null, ['class' => 'form-control', 'placeholder' => 'যেমন: BPATC, NAEM, বিএফডিসি বা অন্য প্রতিষ্ঠান']) !!}
    </div>

    <!-- Location -->
    <div class="col-md-6 mb-3">
        {!! Form::label('location', 'স্থান / দেশ:', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::text('location', null, ['class' => 'form-control', 'placeholder' => 'যেমন: ঢাকা, গাজীপুর, ভারত, অনলাইন']) !!}
    </div>

    <!-- Result / Grade -->
    <div class="col-md-6 mb-3">
        {!! Form::label('result_grade', 'ফলাফল / গ্রেড / অবস্থা:', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::text('result_grade', null, ['class' => 'form-control', 'placeholder' => 'যেমন: উত্তীর্ণ, A+, সন্তোষজনক, অংশগ্রহণমূলক']) !!}
    </div>

    <!-- Certificate File -->
    <div class="col-md-6 mb-3">
        {!! Form::label('certificate_file', 'সনদপত্র সংযুক্তি (PDF/Image):', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::file('certificate_file', ['class' => 'form-control', 'accept' => '.pdf,.jpg,.jpeg,.png']) !!}
        @if(isset($training) && $training->certificate_file)
            <small class="d-block mt-1">
                বর্তমান সনদপত্র: <a href="{{ asset($training->certificate_file) }}" target="_blank" class="text-primary font-weight-bold">দেখুন / ডাউনলোড করুন</a>
            </small>
        @endif
        @error('certificate_file')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Remarks -->
    <div class="col-md-12 mb-4">
        {!! Form::label('remarks', 'মন্তব্য / বিস্তারিত বিবরণ:', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::textarea('remarks', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'প্রশিক্ষণ সম্পর্কিত অতিরিক্ত কোনো তথ্য বা মন্তব্য']) !!}
    </div>
</div>

<div class="d-flex gap-2">
    {!! Form::submit('সংরক্ষণ করুন', ['class' => 'btn text-white font-weight-bold px-4', 'style' => 'background-color: #1f9303 !important; border: none;']) !!}
    <a href="{{ route('staffTrainings.index') }}" class="btn btn-secondary px-4">বাতিল করুন</a>
</div>
