<style>
    .S_Title {
        font-size: 20px !important;
        margin-top: -40px !important;
        margin-bottom: 10px !important;
        text-align: left !important;
    }
    .p_Title {
        font-size: 20px !important;
        margin-bottom: 15px !important;
        text-align: left !important;
        color: #001BFE !important;
        margin-top: 15px;
    }
</style>

<p class="S_Title">ফিল্ম সম্পর্কিত তথ্য:</p>
<!-- চলচ্চিত্রের নাম Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('name', 'চলচ্চিত্রের নাম',['class'=>'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- পরিচালক Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('producer', 'পরিচালক',['class'=>'control-label']) !!}
        {!! Form::text('producer', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- প্রযোজক/প্রযোজনা প্রতিষ্ঠান Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('organization', 'প্রযোজক/প্রযোজনা প্রতিষ্ঠান',['class'=>'control-label']) !!}
        {!! Form::text('organization', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- ধরন Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('type', 'ধরন', ['class'=>'control-label']) !!}
        {!! Form::select('type', ['পূর্ণদৈর্ঘ্য চলচ্চিত্র' => 'পূর্ণদৈর্ঘ্য চলচ্চিত্র', 'স্বল্পদৈর্ঘ্য' => 'স্বল্পদৈর্ঘ্য'], null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- সেন্সর সার্টিফিকেট নম্বর Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('cen_certificate_no', 'সেন্সর সার্টিফিকেট নম্বর',['class'=>'control-label']) !!}
        {!! Form::text('cen_certificate_no', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- সেন্সর অনুমোদনের তারিখ Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('cen_certificate_date', 'সেন্সর অনুমোদনের তারিখ',['class'=>'control-label']) !!}
        {!! Form::date('cen_certificate_date', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- মুক্তির সম্ভাব্য তারিখ Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('publish_date', 'মুক্তির সম্ভাব্য তারিখ',['class'=>'control-label']) !!}
        {!! Form::date('publish_date', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- চিত্রায়নের স্থানসমূহ Field -->
<div class="col-md-12">
    <div class="form-group">
        {!! Form::label('place', 'চিত্রায়নের স্থানসমূহ', ['class'=>'control-label']) !!}
        {!! Form::textarea('place', null, ['class' => 'form-control', 'rows' => 2]) !!}
    </div>
</div>

<p class="p_Title">আবেদনকারীর তথ্য:</p>
<!-- নামের পূর্ণরূপ Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('full_name', 'নামের পূর্ণরূপ',['class'=>'control-label']) !!}
        {!! Form::text('full_name', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- পদবী/দায়িত্ব Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('designation', 'পদবী/দায়িত্ব',['class'=>'control-label']) !!}
        {!! Form::text('designation', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- মোবাইল নম্বর Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('mobile_no', 'মোবাইল নম্বর',['class'=>'control-label']) !!}
        {!! Form::text('mobile_no', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- ই-মেইল Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('email', 'ই-মেইল',['class'=>'control-label']) !!}
        {!! Form::text('email', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- ঠিকানা Field -->
<div class="col-md-8">
    <div class="form-group">
        {!! Form::label('address', 'ঠিবানা', ['class'=>'control-label']) !!}
        {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => 2]) !!}
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('items.index') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
</div>
