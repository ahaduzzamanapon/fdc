
<style>
    /* From Uiverse.io by Bodyhc */ 
.checkbox-wrapper-16 *,
  .checkbox-wrapper-16 *:after,
  .checkbox-wrapper-16 *:before {
  box-sizing: border-box;
}

.checkbox-wrapper-16 .checkbox-input {
  clip: rect(0 0 0 0);
  -webkit-clip-path: inset(100%);
  clip-path: inset(100%);
  height: 1px;
  overflow: hidden;
  position: absolute;
  white-space: nowrap;
  width: 1px;
}

.checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile {
  border-color: #2260ff;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  color: #2260ff;
}

.checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile:before {
  transform: scale(1);
  opacity: 1;
  background-color: #2260ff;
  border-color: #2260ff;
}

.checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile .checkbox-icon,
  .checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile .checkbox-label {
  color: #2260ff;
}

.checkbox-wrapper-16 .checkbox-input:focus + .checkbox-tile {
  border-color: #2260ff;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
}

.checkbox-wrapper-16 .checkbox-input:focus + .checkbox-tile:before {
  transform: scale(1);
  opacity: 1;
}

.checkbox-wrapper-16 .checkbox-tile {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 7rem;
  min-height: 7rem;
  border-radius: 0.5rem;
  border: 2px solid #b5bfd9;
  background-color: #fff;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  transition: 0.15s ease;
  cursor: pointer;
  position: relative;
}

.checkbox-wrapper-16 .checkbox-tile:before {
  content: "";
  position: absolute;
  display: block;
  width: 1.25rem;
  height: 1.25rem;
  border: 2px solid #b5bfd9;
  background-color: #fff;
  border-radius: 50%;
  top: 0.25rem;
  left: 0.25rem;
  opacity: 0;
  transform: scale(0);
  transition: 0.25s ease;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='://www.w3.org/2000/svg' width='192' height='192' fill='%23FFFFFF' viewBox='0 0 256 256'%3E%3Crect width='256' height='256' fill='none'%3E%3C/rect%3E%3Cpolyline points='216 72.005 104 184 48 128.005' fill='none' stroke='%23FFFFFF' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'%3E%3C/polyline%3E%3C/svg%3E");
  background-size: 12px;
  background-repeat: no-repeat;
  background-position: 50% 50%;
}

.checkbox-wrapper-16 .checkbox-tile:hover {
  border-color: #2260ff;
}

.checkbox-wrapper-16 .checkbox-tile:hover:before {
  transform: scale(1);
  opacity: 1;
}

.checkbox-wrapper-16 .checkbox-icon {
  transition: 0.375s ease;
  color: #494949;
}

.checkbox-wrapper-16 .checkbox-icon svg {
  width: 3rem;
  height: 3rem;
}

.checkbox-wrapper-16 .checkbox-label {
  color: #707070;
  transition: 0.375s ease;
  text-align: center;
}

</style>



<!-- Modal -->
<div class="modal fade" id="makePayment" tabindex="-1" role="dialog" aria-labelledby="makePaymentModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="makePaymentModalTitle">{{ __('messages.select_package') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="$('#makePayment').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12" style="display: flex;flex-wrap: wrap;gap: 47px;">
                    @php
                        $packages = \App\Models\Package::all();
                    @endphp

                    @foreach ($packages as $package)
                    <!-- From Uiverse.io by Bodyhc -->
                    <div class="checkbox-wrapper-16">
                        <label class="checkbox-wrapper">
                            <input class="checkbox-input" type="radio" name="package_id" value="{{ $package->id }}">
                            <span class="checkbox-tile">
                                <span class="checkbox-icon">
                                    <svg viewBox="0 0 256 256" fill="currentColor" height="192" width="192"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect fill="none" height="256" width="256"></rect>
                                        <polygon stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                            stroke="currentColor" fill="none"
                                            points="72 40 184 40 240 104 128 224 16 104 72 40"></polygon>
                                        <polygon stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                            stroke="currentColor" fill="none"
                                            points="177.091 104 128 224 78.909 104 128 40 177.091 104"></polygon>
                                        <line stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                            stroke="currentColor" fill="none" y2="104" x2="240" y1="104" x1="16"></line>
                                    </svg>
                                </span>
                                <span class="checkbox-label">{{ $package->name }}</span>
                            </span>
                        </label>
                    </div>
                    @endforeach

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="$('#makePayment').modal('hide')"
                    data-dismiss="modal">{{ __('messages.close') }}</button>
                <button type="button" class="btn btn-primary" onclick="submitPaymentRequest()">{{ __('messages.save_changes') }}</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        function showMakePaymentModal(filmApplicationId) {
            $('#makePayment').modal('show');
            localStorage.setItem('filmApplicationId', filmApplicationId);
        }
        function submitPaymentRequest() {
            const checkedPackageId = $('input[name="package_id"]:checked').val();
            const filmApplicationId = localStorage.getItem('filmApplicationId');
            window.location.href = `{{ route('filmApplications.make_payment', [':filmApplication', ':package_id']) }}`.replace(':filmApplication', filmApplicationId).replace(':package_id', checkedPackageId);
        }
    </script>
@endsection
