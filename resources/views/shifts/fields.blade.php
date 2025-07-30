
@php
    $categories = \App\Models\ItemCategory::all()->pluck('name_bn', key: 'id')->prepend('ক্যাটাগরি নির্বাচন করুন', '')->toArray();
    $items = \App\Models\Item::all()->pluck('name_bn', key: 'id')->prepend('ইটেম নির্বাচন করুন', '')->toArray();
@endphp

<!-- Name Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('name', 'নাম',['class'=>'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Category Id Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('category_id', 'ক্যাটাগরি নির্বাচন',['class'=>'control-label']) !!}
        {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Item Id Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('item_id', 'আইটেম নির্বাচন',['class'=>'control-label']) !!}
        {!! Form::select('item_id', $items, null, ['class' => 'form-control']) !!}
    </div>
</div>


@section('scripts')
    <script type="text/javascript">
        $('#category_id').on('change', function () {
            var category_id = this.value;
            $.ajax({
                url: "{{ route('producer.get_items_by_category') }}",
                type: "GET",
                data: { category_id },
                success: function (data) {
                    $('#item_id').empty();
                    $('#item_id').append('<option value="">-- আইটেম নির্বাচন করুন --</option>');
                    $.each(data, function (i, item) {
                        $('#item_id').append(`<option value="${item.id}">${item.name_bn}</option>`);
                    });
                }
            });
        })
    </script>
@endsection


<!-- Start Time Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('start_time', 'Start Time',['class'=>'control-label']) !!}
        {!! Form::time('start_time', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- End Time Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('end_time', 'End Time',['class'=>'control-label']) !!}
        {!! Form::time('end_time', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Description Field -->
<div class="col-md-12">
    <div class="form-group ">
        {!! Form::label('description', 'Description',['class'=>'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('shifts.index') }}" class="btn btn-danger">Cancel</a>
</div>
