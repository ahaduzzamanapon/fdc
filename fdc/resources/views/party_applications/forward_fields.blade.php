{!! Form::open(['route' => 'partyApplications.st.status','class' => 'form-horizontal col-md-12']) !!}
    <!-- Section: Form -->
    <fieldset class="border p-3 mb-4">
        <legend class="float-none w-auto px-2">তথ্য হাল নাগাদ করুন</legend>
        <input type="hidden" name="film_id" value="@php echo $film->id; @endphp">
        <input type="hidden" name="request_id" value="@php echo $auth_user->id; @endphp">
        <div class="row">
            <div class="col-12">
                <label for="" class="form-label">অবস্থা পরিবর্তন করুন</label> <br>
                <input type="radio" checked name="status" value="forward"> <span>চেক এবং ফরোয়ার্ড</span>
                <input type="radio" name="status" value="backward"> <span>চেক এবং ব্যাকওয়ার্ড</span>
                <input type="radio" name="status" value="approved"> <span>অনুমোদন</span>
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
        <a href="{{ route('partyApplications.forward.table') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
    </div>
{!! Form::close() !!}
